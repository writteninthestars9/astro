<?php
if (!isset($pageTitle)) $pageTitle = "Written In The Stars";
if (!isset($metaDescription)) $metaDescription = "Soulmate synastry reports written with soul, astrology & poetry.";
if (!isset($currentPage)) $currentPage = "";

if (session_status() === PHP_SESSION_NONE) {
  session_start();

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


}

// pricing logic
if (!isset($_SESSION['price'])) {
  if (isset($_GET['utm_campaign']) && strtolower(trim($_GET['utm_campaign'])) === 'paid_july_2') {
    $price = '19.95';
//include 'mail.php';
  } else {
    $price = '19.95';
  }
  $_SESSION['price'] = $price;
} else {
  $price = $_SESSION['price'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script>
(function() {
  function getParam(name) {
    const url = new URL(window.location.href);
    return url.searchParams.get(name);
  }

  const params = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content'];

  params.forEach(function(param) {
    const value = getParam(param);
    if (value) {
      localStorage.setItem(param, value);
    }
  });
})();
</script>

<!-- Google Tag Manager -->
<script>
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id=GTM-WSK5RSK3'+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WSK5RSK3');
</script>
<!-- End Google Tag Manager -->


  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
  <link rel="stylesheet" href="/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">


  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="<?= $pageTitle ?>">
  <meta property="og:description" content="<?= $metaDescription ?>">
  <meta property="og:image" content="https://writteninthestars.site/images/share.jpg">
  <meta property="og:url" content="https://writteninthestars.site/">
  <meta property="og:type" content="website">

  <!-- WhatsApp/Facebook Compatibility -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:image" content="https://writteninthestars.site/images/share.jpg">

  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var grid = document.querySelector('.grid-container');
    imagesLoaded(grid, function () {
      new Masonry(grid, {
        itemSelector: '.category-box',
        columnWidth: 360,
        gutter: 20,
        fitWidth: false  // ⬅️ Key fix: makes last row left-aligned
      });
    });
  });
</script>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lora&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WSK5RSK3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<header class="navbar">
  <a href="/" class="logo">
    <img src="/images/logo.png" alt="Logo" class="logo-img">
    <span class="logo-text">Written In The Stars</span>
  </a>
<div class="hamburger" id="hamburger">☰</div>
  <div class="nav-right">
    <nav class="nav-links" id="navLinks">
      <a href="/">Home</a>
      <a href="/articles">Articles</a>

<!--<div class="dropdown" id="dropdown">
  <button class="dropdown-toggle" onclick="toggleDropdown()">My Stars ▼</button>
  <div class="dropdown-menu">
    <a href="/stored-profiles"><i class="fas fa-star"></i> Stored Profiles</a>
    <a href="/personal-info"><i class="fas fa-user"></i> My Birth Report</a>
    <a href="/synastry-reports"><i class="fas fa-heart"></i> Relationship Report</a>
    <a href="/transit-reports"><i class="fas fa-globe"></i> Live Transits</a>
    <a href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>
</div>-->
    </nav>
  </div>
</header>


