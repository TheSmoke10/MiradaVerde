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
      
      <h2>Nuevo Usuario </h2>
      
    </div>

    
      <div class="col-sm-7 col-sm-12">
        <form class="needs-validation" method="POST" action="/Controller/save_user.php">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="firstName" name="Nombre" required>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Apellido</label>
              <input type="text" class="form-control" id="Apellido" name="Apellido" required>
            </div>

            <div class="col-sm-6">
              <label for="Cui" class="form-label">Cui</label>
              <input type="text" class="form-control" id="Cui" name="Cui" required>
            </div>

            <div class="col-sm-6">
              <label for="Birthday" class="form-label">Fecha de Cumpleaños</label>
              <input type="date" class="form-control" id="Birthday" name="Birthdate" required>
            </div>

            <div class="col-12">
              <label for="username" class="form-label">Correo</label>
              <input type="email" class="form-control" id="username" name="Correo" required>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="address" name="Password" required>
            </div>

            <div class="col-6">
              <label for="gender" class="form-label">Género</label>
              <select class="form-select" id="gender" name="Gender" required>
                <option value="" selected>Seleccione</option>
                <option value="Hombre">Hombre</option>
                <option value="Mujer">Mujer</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="col-sm-6">
              <label for="Telefono" class="form-label">Teléfono</label>
              <input type="text" class="form-control" id="Telefono" name="Telefono" required>
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