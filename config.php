<?php
$host = null;
$user = null;
$pass = null;
$db   = null;
$stripe_secret_key = null;
$stripe_webhook_secret = null;

// Optional local overrides (not committed to git).
if (file_exists(__DIR__ . "/config.local.php")) {
    require __DIR__ . "/config.local.php";
}

if (!$host) {
    $host = getenv("DB_HOST") ?: "localhost";
}
if (!$user) {
    $user = getenv("DB_USER") ?: "root";
}
if ($pass === null) {
    $pass = getenv("DB_PASS");
    if ($pass === false) {
        $pass = "";
    }
}
if (!$db) {
    $db = getenv("DB_NAME") ?: "magicshop";
}

// Set STRIPE_SECRET_KEY in the environment for live/test checkout.
if (!$stripe_secret_key) {
    $stripe_secret_key = getenv("STRIPE_SECRET_KEY");
}
if (!$stripe_secret_key) {
    $stripe_secret_key = "sk_test_replace_with_real_key";
}

// Set STRIPE_WEBHOOK_SECRET for verifying Stripe webhook events.
if (!$stripe_webhook_secret) {
    $stripe_webhook_secret = getenv("STRIPE_WEBHOOK_SECRET");
}
if (!$stripe_webhook_secret) {
    $stripe_webhook_secret = "whsec_replace_with_real_secret";
}

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
