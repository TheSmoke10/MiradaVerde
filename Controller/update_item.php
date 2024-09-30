<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirige al login si no está autenticado
    exit;
}

// Conexión a la base de datos
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $nombre = utf8_decode($nombre);  // Usar utf8_decode para evitar problemas con SQL Server
    $descripcion = utf8_decode($descripcion);  // Similar para la descripción

    // Manejo de la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = "../Images/" . $nombreImagen;

        // Verifica si el directorio existe, si no, lo crea
        if (!is_dir('Images')) {
            mkdir('Images', 0777, true);
        }

        // Mover la imagen a la carpeta de destino
        if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            die("Error al mover la imagen.");
        }
    }

    // Manejo de la subida del modelo 3D
    if (isset($_FILES['modelo3d']) && $_FILES['modelo3d']['error'] == UPLOAD_ERR_OK) {
        $modelo3D = $_FILES['modelo3d'];
        $nombreModelo3D = basename($modelo3D['name']);
        $rutaModelo3D = "../Models/" . $nombreModelo3D;

        // Verifica si el directorio existe, si no, lo crea
        if (!is_dir('Models')) {
            mkdir('Models', 0777, true);
        }

        // Mover el modelo a la carpeta de destino
        if (!move_uploaded_file($modelo3D['tmp_name'], $rutaModelo3D)) {
            die("Error al mover el modelo 3D.");
        }
    }

    // Preparar la consulta de actualización
    $updateQuery = "UPDATE items SET Name = ?, Description = ? WHERE IdItems = ?";
    $updateParams = array($nombre, $descripcion, $id);

    // Ejecutar la consulta de actualización
    $updateStmt = sqlsrv_query($conn, $updateQuery, $updateParams);

    if ($updateStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Redirigir después de actualizar
        regenerateJson();
        header("Location: ../itemV.php"); // Redirigir a la lista de ítems
        exit;
    }
}

// Cerrar la conexión
sqlsrv_close($conn);
function regenerateJson() {
    // Conectar a la base de datos
    include("connect.php");

    // Consulta para obtener los items de la base de datos
    $query = "SELECT Name, Description, URLBundleModel, URLImageModel FROM items";
    $stmt = sqlsrv_query($conn, $query);

    // Verificar si se obtuvieron resultados
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Crear un array para almacenar los ítems
    $items = array();

    // Recorrer los resultados y agregarlos al array
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Añadir cada ítem al array 'items'
        $items[] = array(
            "Name" => utf8_encode($row['Name']),  // Asegurar que los datos estén en UTF-8
            "Description" => utf8_encode($row['Description']),
            "URLBundleModel" => $row['URLBundleModel'],
            "URLImageModel" => $row['URLImageModel']
        );
    }

    // Generar el JSON con los ítems
    $data = array("items" => $items);
    $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // Definir la ruta del archivo JSON
    $jsonFilePath = '../Metadata/NewItemsCollection.json';

    // Si ya existe el archivo, eliminarlo
    if (file_exists($jsonFilePath)) {
        if (!unlink($jsonFilePath)) {
            die("Error al eliminar el archivo JSON existente.");
        }
    }

    // Crear un nuevo archivo JSON y escribir los datos
    if (file_put_contents($jsonFilePath, $jsonData) === false) {
        die("Error al escribir los datos en el archivo JSON.");
    }

    // Cerrar la conexión y liberar recursos
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    header("Location: ../itemV.php?message=json_created");
}



?>
