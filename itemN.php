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




<div class="container my-2">
  <div class="p-5 text-center bg-body-tertiary rounded-2">

    <div class="container">
  <main>
    <div class="py-5 text-center">
      
      <h2>Nuevo Item </h2>
      
    </div>

    
      <div class="col-sm-7 col-sm-12">
        <form class="needs-validation" action="/Controller/itemNC.php" method="POST" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-sm-12">
              <label for="firstName" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="firstName" name="name" required>
              <div class="invalid-feedback">
                Ingrese Nombre.
              </div>
            </div>

            <div class="col-sm-12">
              <label for="description" class="form-label">Descripción</label>
              <input type="text" class="form-control" id="description" name="description" required>
              <div class="invalid-feedback">
                Ingrese Descripción.
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="formFileImage" class="form-label">Imagen</label>
                <input class="form-control" type="file" name="image" id="formFileImage" accept="image/*" required>
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="formFileModel" class="form-label">Modelo 3D</label>
                <input class="form-control" type="file" name="model" id="formFileModel" required>
              </div>
            </div>

            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
    include("complement/footer.php");
?>

  </body>
</html>