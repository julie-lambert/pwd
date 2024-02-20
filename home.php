

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  <link rel="stylesheet" href="./assets/css/index.css">
</head>

<body>
  <?php 
    require_once "header.php";
  ?>
 
  <h1 class="counter">
    0
  </h1>
  <div class="overlay">
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
  </div>



  <div class="header">
    <div class="h1">M</div>
    <div class="h1">L</div>
    <div class="h1">M</div>
    <div class="h1">V</div>
    <div class="h1">C</div>
    <div class="h1">.</div>
  </div>
  <div class="hero">
    <img src="./assets/img/bg4.jpg" alt="">
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="./scripts/headerScript.js"></script>
</body>

</html>