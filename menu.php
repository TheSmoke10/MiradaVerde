<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige al login si no está autenticado
    exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mirada Verde</title>
    <link rel="shortcut icon" href="/Img/icon-back.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
    <?php
    include("complement/header.php");
    ?>




<div class="container my-5">
  <div class="p-5 text-center bg-body-tertiary rounded-3">
    <img class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100" src="/Img/icon-back.png"/>
    <h1 class="text-body-emphasis">Mirada Verde</h1>
    <p class="col-lg-8 mx-auto fs-5 text-muted">
    La naturaleza cobra vida en tus manos.
    </p>
    <div class="d-inline-flex gap-2 mb-5">
    </div>
  </div>
</div>
<?php
    include("complement/footer.php");
?>

  </body>
</html>