<?php
require "config.php";

$payload = file_get_contents("php://input");
$sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"] ?? "";

if (!$stripe_webhook_secret || $stripe_webhook_secret === "whsec_replace_with_real_secret") {
    http_response_code(500);
    echo "Webhook not configured.";
    exit;
}

function parse_sig_header($header) {
    $timestamp = null;
    $signatures = [];
    $items = explode(",", $header);
    foreach ($items as $item) {
        $parts = explode("=", $item, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key = $parts[0];
        $value = $parts[1];
        if ($key === "t") {
            $timestamp = $value;
        }
        if ($key === "v1") {
            $signatures[] = $value;
        }
    }
    return [$timestamp, $signatures];
}

function verify_signature($payload, $header, $secret, $tolerance = 300) {
    list($timestamp, $signatures) = parse_sig_header($header);
    if (!$timestamp || empty($signatures)) {
        return false;
    }
    if (abs(time() - (int)$timestamp) > $tolerance) {
        return false;
    }
    $signed_payload = $timestamp . "." . $payload;
    $expected = hash_hmac("sha256", $signed_payload, $secret);
    foreach ($signatures as $signature) {
        if (hash_equals($expected, $signature)) {
            return true;
        }
    }
    return false;
}

if (!verify_signature($payload, $sig_header, $stripe_webhook_secret)) {
    http_response_code(400);
    echo "Invalid signature.";
    exit;
}

$event = json_decode($payload, true);
if (!is_array($event) || !isset($event["type"])) {
    http_response_code(400);
    echo "Invalid payload.";
    exit;
}

if ($event["type"] === "checkout.session.completed") {
    $session = $event["data"]["object"] ?? [];
    $event_id = $event["id"] ?? "";
    $session_id = $session["id"] ?? "";
    $amount_total = $session["amount_total"] ?? 0;
    $currency = $session["currency"] ?? "";
    $payment_status = $session["payment_status"] ?? "";
    $customer_email = "";
    if (isset($session["customer_details"]["email"])) {
        $customer_email = $session["customer_details"]["email"];
    } elseif (isset($session["customer_email"])) {
        $customer_email = $session["customer_email"];
    }
    $metadata = $session["metadata"] ?? [];
    $product_id = $metadata["product_id"] ?? "";
    $product_name = $metadata["product_name"] ?? "";
    $username = $metadata["username"] ?? "";
    $client_reference_id = $session["client_reference_id"] ?? "";

    if ($event_id && $session_id) {
        $stmt = $conn->prepare(
            "INSERT INTO orders (stripe_event_id, stripe_session_id, client_reference_id, username, customer_email, product_id, product_name, amount_total, currency, payment_status) " .
            "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) " .
            "ON DUPLICATE KEY UPDATE payment_status = VALUES(payment_status), amount_total = VALUES(amount_total), currency = VALUES(currency)"
        );
        if ($stmt) {
            $stmt->bind_param(
                "sssssssiss",
                $event_id,
                $session_id,
                $client_reference_id,
                $username,
                $customer_email,
                $product_id,
                $product_name,
                $amount_total,
                $currency,
                $payment_status
            );
            $stmt->execute();
            $stmt->close();
        }
    }
}

http_response_code(200);
echo "ok";
?>
