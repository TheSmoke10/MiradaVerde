<?php
session_start(); // Iniciar sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Verifica si el ID del ítem fue pasado en la URL
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Conectar a la base de datos
    include("connect.php");

    // Preparar la consulta para eliminar el ítem
    $query = "DELETE FROM items WHERE IdItems = ?";
    $params = array($itemId);

    // Ejecutar la consulta
    $stmt = sqlsrv_query($conn, $query, $params);

    // Verificar si la consulta fue exitosa
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Redirigir a la lista de ítems después de la eliminación
        regenerateJson();
        header("Location: ../itemV.php?message=deleted");
        exit;
    }

    // Cerrar la conexión
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    
} else {
    // Si no se pasa el ID, redirigir a la lista de ítems
    header("Location: ../itemV.php");
    exit;
}


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
