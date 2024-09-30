<?php
// Incluye la conexión a la base de datos
include("connect.php");

// Verifica si se recibió un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['IdUser'];
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $cui = $_POST['Cui'];
    $birthdate = $_POST['Birthdate'];
    $correo = $_POST['Correo'];
    $telefono = $_POST['Telefono'];
    $gender = $_POST['Gender'];
    $password = $_POST['Password'];

    // Verifica si la contraseña fue proporcionada
    if (empty($password)) {
        // Si la contraseña no fue proporcionada, actualiza sin cambiarla
        $query = "UPDATE [dbo].[user] SET Nombre = ?, Apellido = ?, Cui = ?, Birthdate = ?, Correo = ?, Telefono = ?, Gender = ? WHERE IdUser = ?";
        $params = array($nombre, $apellido, $cui, $birthdate, $correo, $telefono, $gender, $userId);
    } else {
        // Si la contraseña fue proporcionada, actualiza incluyendo la nueva contraseña (hasheada)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE [dbo].[user] SET Nombre = ?, Apellido = ?, Cui = ?, Birthdate = ?, Correo = ?, Telefono = ?, Gender = ?, Password = ? WHERE IdUser = ?";
        $params = array($nombre, $apellido, $cui, $birthdate, $correo, $telefono, $gender, $hashedPassword, $userId);
    }

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Redirige a la lista de usuarios después de la edición
    header('Location: ../userV.php');
    exit;
}

// Cierra la conexión
sqlsrv_close($conn);
?>
