<?php
session_start();
$session_id = "";
if (isset($_GET["session_id"])) {
    $session_id = htmlspecialchars($_GET["session_id"], ENT_QUOTES);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Payment Success</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
  </style>
</head>
<body class="w3-light-grey">
  <div class="w3-content w3-padding-64" style="max-width:640px">
    <div class="w3-card w3-white w3-padding">
      <h2 class="w3-text-purple">Payment successful</h2>
      <p>Thanks for your order. A Stripe receipt will be sent to the email used at checkout.</p>
      <?php if ($session_id): ?>
        <p class="w3-small w3-text-grey">Session ID: <?php echo $session_id; ?></p>
      <?php endif; ?>
      <a class="w3-button w3-purple" href="index.php#services">Back to shop</a>
      <?php if (isset($_SESSION["user"])): ?>
        <a class="w3-button w3-white w3-border" href="orders.php">View orders</a>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
