<!DOCTYPE html>
<html lang="en">
<head>
  <title>Payment Canceled</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
    body {font-size:16px;margin:0}
    .mybrand {font-weight:bold;text-decoration:none;color:inherit}
    .header-bar {display:flex;justify-content:space-between;align-items:center;padding:8px 20px}
    .header-center {flex:1;display:flex;justify-content:center}
    .header-actions {display:flex;gap:10px;align-items:center}
    .w3-main {margin-left:340px;margin-right:40px}
    @media (max-width:992px){
      .w3-main {margin-left:0}
      .w3-sidebar {display:none}
    }
  </style>
</head>
<body class="w3-light-grey">
  <div class="w3-top">
    <div class="w3-bar w3-white w3-card">
      <div class="header-bar">
        <div class="header-center">
          <a href="index.php#showcase" class="mybrand w3-button">Magic Shop</a>
        </div>
        <div class="w3-hide-small header-actions">
          <a class="w3-button w3-white w3-border" href="index.php#services">Back to shop</a>
        </div>
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
          <i class="fa fa-bars"></i>
        </a>
      </div>
    </div>
  </div>

  <nav class="w3-sidebar w3-purple w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar">
    <br>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="w3-container">
      <h3 class="w3-padding-64"><b>MAGIC<br>SHOP</b></h3>
    </div>
    <div class="w3-bar-block">
      <a href="index.php#showcase" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a>
      <a href="index.php#services" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Apparel</a>
      <a href="index.php#designers" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Merchandise</a>
      <a href="index.php#packages" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">About us</a>
      <a href="index.php#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
      <a href="orders.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">My Orders</a>
    </div>
  </nav>

  <header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding" style="top:48px">
    <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">Menu</a>
    <span>Magic Shop</span>
  </header>

  <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

  <div class="w3-main">
    <div class="w3-content w3-padding-64" style="max-width:640px;margin-top:80px">
      <div class="w3-card w3-white w3-padding">
        <h2 class="w3-text-purple">Payment canceled</h2>
        <p>No charge was made. You can return to the shop and try again.</p>
        <a class="w3-button w3-purple" href="index.php#services">Back to shop</a>
      </div>
    </div>
  </div>

  <script>
  function w3_open(){
    document.getElementById("mySidebar").style.display="block";
    document.getElementById("myOverlay").style.display="block";
  }
  function w3_close(){
    document.getElementById("mySidebar").style.display="none";
    document.getElementById("myOverlay").style.display="none";
  }
  </script>
</body>
</html>
