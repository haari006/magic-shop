<?php
session_start();
require "config.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed."]);
    exit;
}

$payload = json_decode(file_get_contents("php://input"), true);
$product_id = "";
if (is_array($payload) && isset($payload["productId"])) {
    $product_id = $payload["productId"];
} elseif (isset($_POST["productId"])) {
    $product_id = $_POST["productId"];
}
$product_id = trim($product_id);

$catalog = [
    "app1" => [
        "name" => "BoraHeart",
        "description" => "Unisex Classic Pullover Hoodie",
        "amount" => 15900,
        "currency" => "myr",
    ],
    "app2" => [
        "name" => "Love Myself",
        "description" => "Unisex Classic Pullover Hoodie",
        "amount" => 15900,
        "currency" => "myr",
    ],
    "app3" => [
        "name" => "Only You In My Eyes",
        "description" => "Unisex Classic Pullover Hoodie",
        "amount" => 14900,
        "currency" => "myr",
    ],
    "app4" => [
        "name" => "Waves Of Life",
        "description" => "Unisex Premium Pullover Hoodie",
        "amount" => 18900,
        "currency" => "myr",
    ],
    "app5" => [
        "name" => "Panda Vibes",
        "description" => "Embroidered Soft-Wash Hoodie",
        "amount" => 16900,
        "currency" => "myr",
    ],
    "app6" => [
        "name" => "Believe In Yourself",
        "description" => "Unisex Classic t-Shirt",
        "amount" => 9900,
        "currency" => "myr",
    ],
    "m1" => [
        "name" => "BTSCN",
        "description" => "Stylized short form of BTS Scene",
        "amount" => 3900,
        "currency" => "myr",
    ],
    "m2" => [
        "name" => "ONSET",
        "description" => "Inspired by their song ON",
        "amount" => 3900,
        "currency" => "myr",
    ],
    "m3" => [
        "name" => "RUN7",
        "description" => "Dynamic and youthful",
        "amount" => 3900,
        "currency" => "myr",
    ],
    "m4" => [
        "name" => "HYBE7",
        "description" => "For modern, minimal branding",
        "amount" => 4900,
        "currency" => "myr",
    ],
    "m5" => [
        "name" => "BTSZN",
        "description" => "BTS Season, trendy slang",
        "amount" => 3900,
        "currency" => "myr",
    ],
    "m6" => [
        "name" => "UNIVER7E",
        "description" => "Aesthetic version of Universe",
        "amount" => 3900,
        "currency" => "myr",
    ],
];

if (!$product_id || !isset($catalog[$product_id])) {
    http_response_code(400);
    echo json_encode(["error" => "Unknown product."]);
    exit;
}

if (!$stripe_secret_key || $stripe_secret_key === "sk_test_replace_with_real_key") {
    http_response_code(500);
    echo json_encode(["error" => "Stripe is not configured."]);
    exit;
}

$product = $catalog[$product_id];
$username = null;
$user_email = null;
if (isset($_SESSION["user"])) {
    $username = $_SESSION["user"];
    $stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $user_email = $row["email"];
        }
        $stmt->close();
    }
}
$scheme = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
$script_dir = rtrim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");
$base_url = $scheme . "://" . $_SERVER["HTTP_HOST"] . $script_dir;

$success_url = $base_url . "/checkout_success.php?session_id={CHECKOUT_SESSION_ID}";
$cancel_url = $base_url . "/checkout_cancel.php";

$params = [
    "mode" => "payment",
    "success_url" => $success_url,
    "cancel_url" => $cancel_url,
    "metadata" => [
        "product_id" => $product_id,
        "product_name" => $product["name"],
    ],
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => $product["currency"],
                "unit_amount" => $product["amount"],
                "product_data" => [
                    "name" => $product["name"],
                    "description" => $product["description"],
                ],
            ],
        ],
    ],
];
if ($username) {
    $params["client_reference_id"] = $username;
    $params["metadata"]["username"] = $username;
}
if ($user_email) {
    $params["customer_email"] = $user_email;
}

$body = http_build_query($params, "", "&");

$ch = curl_init("https://api.stripe.com/v1/checkout/sessions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $stripe_secret_key,
    "Content-Type: application/x-www-form-urlencoded",
]);

$response = curl_exec($ch);
if ($response === false) {
    http_response_code(500);
    echo json_encode(["error" => "Stripe request failed."]);
    exit;
}

$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);
if ($status < 200 || $status >= 300 || !isset($data["url"])) {
    $message = "Stripe error.";
    if (is_array($data) && isset($data["error"]["message"])) {
        $message = $data["error"]["message"];
    }
    http_response_code(500);
    echo json_encode(["error" => $message]);
    exit;
}

echo json_encode(["url" => $data["url"]]);
?>
