<?php
// Incluye la conexión a la base de datos
include("connect.php");

// Verifica si se ha proporcionado un IdUser para eliminar
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Preparar la consulta SQL para eliminar el usuario
    $sql = "DELETE FROM [dbo].[user] WHERE IdUser = ?";

    // Parámetros para la consulta
    $params = array($userId);

    // Ejecutar la consulta
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Verificar si la consulta fue exitosa
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Usuario eliminado exitosamente.";
    }

    // Cierra la conexión
    sqlsrv_close($conn);

    // Redirigir a la página de visualización de usuarios después de la eliminación
    header("Location: ../userV.php");
    exit;
} else {
    // Si no se proporciona un IdUser, redirigir o mostrar mensaje de error
    echo "ID de usuario no proporcionado.";
}
?>
