<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige al login si no está autenticado
    exit;
}

// Conexión a la base de datos
include("Controller/connect.php");

// Verificar si se recibió un 'id' por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para obtener los datos del ítem a editar
    $query = "SELECT Name, Description FROM items WHERE IdItems = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $query, $params);

    // Verificar si la consulta fue exitosa
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Obtener los datos del ítem
    $item = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if (!$item) {
        echo "No se encontró el ítem con ese ID.";
        exit;
    }

} else {
    echo "No se especificó un ítem válido para editar.";
    exit;
}

// Cerrar la conexión a la base de datos
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Item</title>
    <link rel="shortcut icon" href="/Img/icon-back.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php include("complement/header.php"); ?>

    <div class="container my-2">
        <div class="p-5 text-center bg-body-tertiary rounded-2">
            <main>
                <div class="py-5 text-center">
                    <h2>Editar Item</h2>
                </div>

                <div class="col-sm-7 col-sm-12">
                    <form class="needs-validation" method="POST" action="/Controller/update_item.php" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars(utf8_encode($item['Name'])); ?>" required>
                                <div class="invalid-feedback">Nombre es requerido.</div>
                            </div>

                            <div class="col-sm-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars(utf8_encode($item['Description'])); ?>" required>
                                <div class="invalid-feedback">Descripción es requerida.</div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label">Imagen (opcional)</label>
                                    <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="modelo3d" class="form-label">Modelo 3D (opcional)</label>
                                    <input class="form-control" type="file" id="modelo3d" name="modelo3d">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <button class="w-100 btn btn-primary btn-lg" type="submit">Guardar</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php include("complement/footer.php"); ?>
</body>
</html>
