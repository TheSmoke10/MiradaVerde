<?php
session_start(); // Iniciar sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: /../login.php");
    exit;
}

// Conexión a la base de datos
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = date('Y-m-d H:i:s');
    $state = 1; // Estado activo por defecto

    // Asegurarse de que el texto se maneje en UTF-8
    $name = utf8_decode($name);  // Usar utf8_decode para evitar problemas con SQL Server
    $description = utf8_decode($description);  // Similar para la descripción

    // Manejo de la subida de la imagen
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $imageName = basename($image['name']);
        $imagePath = "../Images/" . $imageName; // Ruta relativa
        $urlImage = "https://miradaverde.sysmariano.online/Images/" . $imageName;

        // Verifica si el directorio existe, si no, lo crea
        if (!is_dir('Images')) {
            mkdir('Images', 0777, true);
        }

        // Mover la imagen a la carpeta de destino
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            die("Error al mover la imagen.");
        }
    }

    // Manejo de la subida del modelo 3D
    if (isset($_FILES['model'])) {
        $model = $_FILES['model'];
        $modelName = basename($model['name']);
        $modelPath = "../Models/" . $modelName; // Ruta relativa
        $urlModel = "https://miradaverde.sysmariano.online/Models/" . $modelName;

        // Verifica si el directorio existe, si no, lo crea
        if (!is_dir('Models')) {
            mkdir('Models', 0777, true);
        }

        // Mover el modelo a la carpeta de destino
        if (!move_uploaded_file($model['tmp_name'], $modelPath)) {
            die("Error al mover el modelo 3D.");
        }
    }

    // Insertar los datos en la base de datos
    $query = "INSERT INTO items (Name, Description, ImageName, ImagePath, URLImageModel, ModelName, ModelPath, URLBundleModel, Date, State)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $params = array($name, $description, $imageName, $imagePath, $urlImage, $modelName, $modelPath, $urlModel, $date, $state);

    // Ejecutar la consulta
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Item guardado exitosamente.";
    }

    // Cerrar la conexión y liberar recursos
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    // Regenerar el JSON después de guardar el ítem
    regenerateJson();

    // Redirigir después de la operación
    
    exit;
}

// Función para regenerar el JSON con los datos actualizados
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
