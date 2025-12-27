<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Magic Shop</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;margin:0}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
.mybrand {font-weight:bold;text-decoration:none;color:inherit}
.header-bar {display:flex;justify-content:space-between;align-items:center;padding:8px 20px}
.header-center {flex:1;display:flex;justify-content:center}
.header-actions {display:flex;gap:10px;align-items:center}
.w3-modal .w3-modal-content {max-width:420px}
.w3-main {margin-left:340px;margin-right:40px}
@media (max-width:992px){
  .w3-main {margin-left:0}
  .w3-sidebar {display:none}
}
</style>
</head>
<body>

<div class="w3-top">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    <div class="header-bar">
      <div class="header-center">
        <a href="#home" class="mybrand w3-button">Express your love for BTS 💜 Made by <span class="w3-tag">ARMY</span></a>
      </div>
      <div class="w3-hide-small header-actions">
        <?php if(isset($_SESSION["user"])): ?>
          <span id="sessionUser" class="w3-text-purple">Hello, <?php echo htmlspecialchars($_SESSION["user"], ENT_QUOTES); ?></span>
          <a class="w3-button w3-white w3-border" href="orders.php">My Orders</a>
          <button class="w3-button w3-red" id="btnLogout">Logout</button>
        <?php else: ?>
          <button class="w3-button w3-purple" id="btnLogin">Login</button>
          <button class="w3-button w3-white w3-border" id="btnRegister">Register</button>
        <?php endif; ?>
      </div>
      <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>
</div>

<div class="mySlides w3-display-container w3-center" style="margin-top:48px">
  <img src="btsbanner5.jpg" style="max-width:100%;height:auto" class="w3-hover-opacity" alt="banner">
</div>

<nav class="w3-sidebar w3-purple w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar">
  <br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>MAGIC<br>SHOP</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="#showcase" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a>
    <a href="#services" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Apparel</a>
    <a href="#designers" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Merchandise</a>
    <a href="#packages" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">About us</a>
    <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
  </div>
</nav>

<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding" style="top:48px">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Company Name</span>
</header>

<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

<div class="w3-main">

  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>ARMYVERSE</b></h1>
    <h1 class="w3-xxxlarge w3-text-purple"><b>Showcase.</b></h1>
  </div>

  <div class="w3-row-padding">
    <div class="w3-half">
      <img src="BTS 1.jpg" style="width:100%" onclick="onClick(this)" alt="Photo session">
      <img src="bts 2.jpg" style="width:100%" onclick="onClick(this)" alt="World tour 2017">
    </div>
    <div class="w3-half">
      <img src="bts 3.jpg" style="width:100%" onclick="onClick(this)" alt="World tour 2021">
      <img src="bts 4.png" style="width:100%" onclick="onClick(this)" alt="Hot album">
    </div>
  </div>

  <div id="modal01" class="w3-modal" onclick="this.style.display='none'">
    <div class="w3-modal-content w3-animate-zoom w3-center w3-black w3-padding-64">
      <span class="w3-button w3-xxlarge w3-display-topright" onclick="document.getElementById('modal01').style.display='none'">×</span>
      <img id="img01" class="w3-image" style="max-width:90%;height:auto">
      <p id="caption" class="w3-text-white"></p>
    </div>
  </div>

  <div class="w3-container" id="services" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-purple"><b>Apparel</b></h1>
    <p><b>Featured Products</b>:</p>
  </div>

  <div class="w3-row-padding w3-grayscale">
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="app1.jpg" style="width:100%" onclick="onClick(this)" alt="BoraHeart">
        <div class="w3-container">
          <h3>BoraHeart</h3>
          <p class="w3-opacity">Unisex Classic Pullover Hoodie</p>
          <p class="w3-large w3-text-purple"><b>MYR 159</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="app1">Buy</button>
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="app2.jpg" style="width:100%" onclick="onClick(this)" alt="Love Myself">
        <div class="w3-container">
          <h3>Love Myself</h3>
          <p class="w3-opacity">Unisex Classic Pullover Hoodie</p>
          <p class="w3-large w3-text-purple"><b>MYR 159</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="app2">Buy</button>
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="app3.jpg" style="width:100%" onclick="onClick(this)" alt="Only You In My Eyes">
        <div class="w3-container">
          <h3>Only You In My Eyes</h3>
          <p class="w3-opacity">Unisex Classic Pullover Hoodie</p>
          <p class="w3-large w3-text-purple"><b>MYR 149</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="app3">Buy</button>
        </div>
      </div>
    </div>

    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="app4.jpg" style="width:100%" onclick="onClick(this)" alt="Waves Of Life">
        <div class="w3-container">
          <h3>Waves Of Life</h3>
          <p class="w3-opacity">Unisex Premium Pullover Hoodie</p>
          <p class="w3-large w3-text-purple"><b>MYR 189</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="app4">Buy</button>
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="app5.jpg" style="width:100%" onclick="onClick(this)" alt="Panda Vibes">
        <div class="w3-container">
          <h3>Panda Vibes</h3>
          <p class="w3-opacity">Embroidered Soft-Wash Hoodie</p>
          <p class="w3-large w3-text-purple"><b>MYR 169</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="app5">Buy</button>
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="app6.jpg" style="width:100%" onclick="onClick(this)" alt="Believe In Yourself">
        <div class="w3-container">
          <h3>Believe In Yourself</h3>
          <p class="w3-opacity">Unisex Classic t-Shirt</p>
          <p class="w3-large w3-text-purple"><b>MYR 99</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="app6">Buy</button>
        </div>
      </div>
    </div>
  </div>

  <div class="w3-container" id="designers" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-purple"><b>Merchandise.</b></h1>
    <p><b>Featured Products</b>:</p>
  </div>

  <div class="w3-row-padding w3-grayscale">
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="m1.jpg" style="width:100%" onclick="onClick(this)" alt="BTSCN">
        <div class="w3-container">
          <h3>BTSCN</h3>
          <p class="w3-opacity">Stylized short form of “BTS Scene”</p>
          <p class="w3-large w3-text-purple"><b>MYR 39</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="m1">Buy</button>
          
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="m2.jpg" style="width:100%" onclick="onClick(this)" alt="ONSET">
        <div class="w3-container">
          <h3>ONSET</h3>
          <p class="w3-opacity">Inspired by their song ON</p>
          <p class="w3-large w3-text-purple"><b>MYR 39</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="m2">Buy</button>
          
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="m3.jpg" style="width:100%" onclick="onClick(this)" alt="RUN7">
        <div class="w3-container">
          <h3>RUN7</h3>
          <p class="w3-opacity">Dynamic and youthful</p>
          <p class="w3-large w3-text-purple"><b>MYR 39</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="m3">Buy</button>
          
        </div>
      </div>
    </div>

    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="m4.jpg" style="width:100%" onclick="onClick(this)" alt="HYBE7">
        <div class="w3-container">
          <h3>HYBE7</h3>
          <p class="w3-opacity">For modern, minimal branding</p>
          <p class="w3-large w3-text-purple"><b>MYR 49</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="m4">Buy</button>
          
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="m5.jpg" style="width:100%" onclick="onClick(this)" alt="BTSZN">
        <div class="w3-container">
          <h3>BTSZN</h3>
          <p class="w3-opacity">“BTS Season,” trendy slang</p>
          <p class="w3-large w3-text-purple"><b>MYR 39</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="m5">Buy</button>
          
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="m6.jpg" style="width:100%" onclick="onClick(this)" alt="UNIVER7E">
        <div class="w3-container">
          <h3>UNIVER7E</h3>
          <p class="w3-opacity">Aesthetic version of “Universe”</p>
          <p class="w3-large w3-text-purple"><b>MYR 39</b></p>
          <button class="w3-button w3-purple w3-block buy-button" data-product-id="m6">Buy</button>
          
        </div>
      </div>
    </div>
  </div>

  <div class="w3-container" id="packages" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-purple"><b>About Us.</b></h1>
    <p><b>✨ Step into a world where music meets comfort, and every design carries the heart of BTS and ARMY !</b></p>
    <p>Magic Shop is a BTS inspired "Pre-ordered" online store created for ARMYs who believe in love, hope, and self expression. Just like the song “Magic Shop,” this space is a comfort zone where every item tells a story of connection between BTS and their fans. Our collections are designed to inspire confidence, warmth, and positivity in your daily life. Step inside, find your magic, and wear your love proudly.💜 </p>
    <p>Here, every product carries a piece of the BTS spirit and the love of ARMY. We believe that even small things like a sweater, a tumbler, a sticker can bring comfort and joy. Each design is made with passion, inspired by the message of “Love Yourself.” This is more than a shop it’s a home where music, dreams, and purple hearts come together.🌙✨</p>
  </div>

  <div class="w3-container" id="contact" style="margin-top:75px">
    <div class="w3-row w3-padding-32">
      <div class="w3-col m6 w3-large w3-margin-bottom">
        <h1 class="w3-xxxsmall w3-text-purple"><b>Contact us</b></h1>
        <i class="fa fa-map-marker" style="width:30px"></i> Kuala Lumpur, Malaysia<br>
        <i class="fa fa-phone" style="width:30px"></i> Phone: +60-169158270<br>
        <i class="fa fa-envelope" style="width:30px"></i> Email: kpopbtsmerch@gmail.com<br>
      </div>
      <div class="w3-col m6">
        <form action="/action_page.php" target="_blank">
          <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
            <div class="w3-half">
              <input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
            </div>
            <div class="w3-half">
              <input class="w3-input w3-border" type="email" placeholder="Email" required name="Email">
            </div>
          </div>
          <input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
          <button class="w3-button w3-purple w3-section w3-right" type="submit">SEND</button>
          <p>"Love Myself, Love My Merch 💜" Wear your BTS passion with pride!📦</p>
        </form>
      </div>
    </div>
  </div>

</div>

<div class="w3-bottom">
  <div class="w3-bar w3-white w3-card">
    <div class="w3-right w3-hide-small" style="padding:8px">
      <audio controls autoplay muted>
        <source src="MAGICSHOP.mp3" type="audio/mpeg">
      </audio>
    </div>
  </div>
</div>

<footer class="w3-center w3-black w3-padding-48 w3-xxsmall">
  <div class="w3-container w3-content w3-padding-64" style="max-width:500px">
    <div class="w3-row w3-padding-32">
      <div class="w3-col m12">
        <p class="w3-text-white">© <?php echo date("Y"); ?> Magic Shop. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>

<div id="loginModal" class="w3-modal">
  <div class="w3-modal-content w3-card-4 w3-animate-zoom">
    <div class="w3-center" style="padding:16px">
      <span onclick="closeModal('loginModal')" class="w3-button w3-xlarge w3-display-topright">&times;</span>
      <h2>Login</h2>
    </div>
    <form class="w3-container" id="loginForm" style="padding:16px">
      <p><input class="w3-input w3-border" type="text" placeholder="Username" id="loginUser" required></p>
      <p><input class="w3-input w3-border" type="password" placeholder="Password" id="loginPass" required></p>
      <p class="w3-center"><button class="w3-button w3-purple w3-section" type="submit">Login</button></p>
      <p class="w3-center"><button class="w3-button w3-white w3-border" type="button" id="btnOpenRegister">Register</button></p>
    </form>
  </div>
</div>

<div id="registerModal" class="w3-modal">
  <div class="w3-modal-content w3-card-4 w3-animate-zoom">
    <div class="w3-center" style="padding:16px">
      <span onclick="closeModal('registerModal')" class="w3-button w3-xlarge w3-display-topright">&times;</span>
      <h2>Create Account</h2>
    </div>
    <form class="w3-container" id="registerForm" style="padding:16px">
      <p><input class="w3-input w3-border" type="text" placeholder="Username" id="regUser" required></p>
      <p><input class="w3-input w3-border" type="email" placeholder="Email" id="regEmail" required></p>
      <p><input class="w3-input w3-border" type="password" placeholder="Password" id="regPass" required></p>
      <p class="w3-center"><button class="w3-button w3-purple w3-section" type="submit">Register</button></p>
    </form>
  </div>
</div>

<script>
const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;
function w3_open(){
  document.getElementById("mySidebar").style.display="block";
  document.getElementById("myOverlay").style.display="block";
}
function w3_close(){
  document.getElementById("mySidebar").style.display="none";
  document.getElementById("myOverlay").style.display="none";
}
function onClick(el){
  document.getElementById("img01").src = el.src;
  document.getElementById("modal01").style.display = "block";
  document.getElementById("caption").innerHTML = el.alt;
}
function closeModal(id){
  document.getElementById(id).style.display="none";
}
let btnLogin = document.getElementById("btnLogin");
let btnRegister = document.getElementById("btnRegister");
let btnLogout = document.getElementById("btnLogout");
let btnOpenRegister = document.getElementById("btnOpenRegister");
if (btnLogin) btnLogin.onclick = ()=>{ document.getElementById("loginModal").style.display = "block"; }
if (btnRegister) btnRegister.onclick = ()=>{ document.getElementById("registerModal").style.display = "block"; }
if (btnOpenRegister) btnOpenRegister.onclick = ()=> {
  closeModal("loginModal");
  document.getElementById("registerModal").style.display = "block";
}
if (btnLogout) btnLogout.onclick = ()=> {
  fetch("logout.php").then(r=>r.text()).then(t=>{ if(t.trim()==="success") location.reload(); });
}
document.getElementById("registerForm").onsubmit = function(e){
  e.preventDefault();
  let f = new FormData();
  f.append("username", regUser.value);
  f.append("email", regEmail.value);
  f.append("password", regPass.value);
  fetch("register.php",{method:"POST",body:f}).then(r=>r.text()).then(t=>{
    if(t.trim()==="success"){ alert("Registered successfully"); location.reload(); } else alert(t);
  });
}
document.getElementById("loginForm").onsubmit = function(e){
  e.preventDefault();
  let f = new FormData();
  f.append("username", loginUser.value);
  f.append("password", loginPass.value);
  fetch("login.php",{method:"POST",body:f}).then(r=>r.text()).then(t=>{
    if(t.trim()==="success"){ location.reload(); } else alert(t);
  });
}
async function startCheckout(button){
  if (!isLoggedIn) {
    document.getElementById("loginModal").style.display = "block";
    return;
  }
  let productId = button.dataset.productId;
  if (!productId) return;
  let originalText = button.textContent;
  button.disabled = true;
  button.textContent = "Redirecting...";
  try {
    let res = await fetch("create_checkout_session.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify({ productId: productId })
    });
    let data = await res.json();
    if (!res.ok || !data.url) {
      if (data && data.error === "login_required") {
        document.getElementById("loginModal").style.display = "block";
        return;
      }
      throw new Error(data.error || "Unable to start checkout.");
    }
    window.location.href = data.url;
  } catch (err) {
    alert(err.message);
    button.disabled = false;
    button.textContent = originalText;
  }
}
document.querySelectorAll(".buy-button").forEach(btn=>{
  btn.addEventListener("click", ()=>startCheckout(btn));
});
</script>

</body>
</html>
