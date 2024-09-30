<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige al login si no está autenticado
    exit;
}
// Incluye la conexión a la base de datos
include("Controller/connect.php");

// Verifica si se ha proporcionado un IdUser para la edición
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Consulta para obtener los datos del usuario por su IdUser
    $query = "SELECT IdUser, Nombre, Apellido, Cui, Birthdate, Correo, Telefono, Gender FROM [dbo].[user] WHERE IdUser = ?";
    $params = array($userId);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Obtiene los datos del usuario
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if (!$user) {
        echo "Usuario no encontrado.";
        exit;
    }
} else {
    echo "Id de usuario no proporcionado.";
    exit;
}

// Cierra la conexión temporal
sqlsrv_free_stmt($stmt);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario</title>
    <link rel="shortcut icon" href="/Img/icon-back.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <?php include("complement/header.php"); ?>

    <div class="container my-2">
        <div class="p-5 text-center bg-body-tertiary rounded-2">
            <div class="container">
                <main>
                    <div class="py-5 text-center">
                        <h2>Editar Usuario</h2>
                    </div>
                    <div class="col-sm-7 col-sm-12">
                        <form class="needs-validation" method="POST" action="/Controller/update_user.php">
                            <input type="hidden" name="IdUser" value="<?php echo $user['IdUser']; ?>">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="firstName" name="Nombre" value="<?php echo $user['Nombre']; ?>" required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="lastName" name="Apellido" value="<?php echo $user['Apellido']; ?>" required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="Cui" class="form-label">Cui</label>
                                    <input type="text" class="form-control" id="Cui" name="Cui" value="<?php echo $user['Cui']; ?>" required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="Birthday" class="form-label">Fecha de Cumpleaños</label>
                                    <input type="date" class="form-control" id="Birthday" name="Birthdate" value="<?php echo $user['Birthdate']->format('Y-m-d'); ?>" required>
                                </div>

                                <div class="col-12">
                                    <label for="username" class="form-label">Correo</label>
                                    <input type="email" class="form-control" id="username" name="Correo" value="<?php echo $user['Correo']; ?>" required>
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">Contraseña (Déjela vacía si no desea cambiarla)</label>
                                    <input type="password" class="form-control" id="address" name="Password">
                                </div>

                                <div class="col-6">
                                    <label for="gender" class="form-label">Género</label>
                                    <select class="form-select" id="gender" name="Gender" required>
                                        
                                        <option value="Hombre" <?php if ($user['Gender'] == "Hombre") echo "selected"; ?>>Hombre</option>
                                        <option value="Mujer" <?php if ($user['Gender'] == "Mujer") echo "selected"; ?>>Mujer</option>
                                        <option value="Otro" <?php if ($user['Gender'] == "Otro") echo "selected"; ?>>Otro</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="Telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="Telefono" name="Telefono" value="<?php echo $user['Telefono']; ?>" required>
                                </div>

                                <hr class="my-4">
                                <button class="w-100 btn btn-primary btn-lg" type="submit">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <?php include("complement/footer.php"); ?>
</body>
</html>
