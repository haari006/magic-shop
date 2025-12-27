<?php
session_start();
require "config.php";

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION["user"];
$user_email = "";
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

$sql = "SELECT stripe_session_id, product_name, amount_total, currency, payment_status, created_at FROM orders WHERE username = ? OR client_reference_id = ?";
$types = "ss";
$params = [$username, $username];
if ($user_email) {
    $sql .= " OR customer_email = ?";
    $types .= "s";
    $params[] = $user_email;
}
$sql .= " ORDER BY created_at DESC";

$orders = [];
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    $stmt->close();
}

function format_amount($amount, $currency) {
    $value = number_format(((int)$amount) / 100, 2);
    return strtoupper($currency) . " " . $value;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Orders</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
  </style>
</head>
<body class="w3-light-grey">
  <div class="w3-content w3-padding-64" style="max-width:900px">
    <div class="w3-card w3-white w3-padding">
      <h2 class="w3-text-purple">My Orders</h2>
      <p class="w3-small">Signed in as <?php echo htmlspecialchars($username, ENT_QUOTES); ?></p>
      <?php if (count($orders) === 0): ?>
        <p>No orders yet. When you complete a checkout, it will appear here.</p>
      <?php else: ?>
        <div class="w3-responsive">
          <table class="w3-table w3-bordered">
            <thead>
              <tr class="w3-light-grey">
                <th>Product</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Placed</th>
                <th>Session</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $order): ?>
                <tr>
                  <td><?php echo htmlspecialchars($order["product_name"], ENT_QUOTES); ?></td>
                  <td><?php echo htmlspecialchars(format_amount($order["amount_total"], $order["currency"]), ENT_QUOTES); ?></td>
                  <td><?php echo htmlspecialchars($order["payment_status"], ENT_QUOTES); ?></td>
                  <td><?php echo htmlspecialchars($order["created_at"], ENT_QUOTES); ?></td>
                  <td><?php echo htmlspecialchars($order["stripe_session_id"], ENT_QUOTES); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
      <a class="w3-button w3-purple w3-margin-top" href="index.php#services">Back to shop</a>
    </div>
  </div>
</body>
</html>
