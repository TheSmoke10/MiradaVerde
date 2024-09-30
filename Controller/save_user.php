<?php
include("connect.php");

// Capturar datos del formulario y eliminar espacios adicionales
$nombre = trim($_POST['Nombre']);
$apellido = trim($_POST['Apellido']);
$correo = trim($_POST['Correo']);
$password = $_POST['Password']; // No se debe hacer trim a contraseñas
$cui = trim($_POST['Cui']);
$birthdate = $_POST['Birthdate']; // No requiere trim ya que es fecha
$gender = trim($_POST['Gender']);
$Telefono = trim($_POST['Telefono']);

// Encriptar la contraseña
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Preparar la consulta SQL para insertar datos
$sql = "INSERT INTO [dbo].[user] (IdUser, Nombre, Apellido, Correo, Password, Cui, Birthdate, Gender, Telefono) 
        VALUES ((SELECT ISNULL(MAX(IdUser), 0) + 1 FROM [dbo].[user]), ?, ?, ?, ?, ?, ?, ?, ?)";

// Preparar la consulta para evitar inyecciones SQL
$params = array($nombre, $apellido, $correo, $password_hashed, $cui, $birthdate, $gender, $Telefono);

// Ejecutar la consulta
$stmt = sqlsrv_query($conn, $sql, $params);

// Verificar si la consulta fue exitosa
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "Datos guardados exitosamente.";
}

// Cerrar la conexión
sqlsrv_close($conn);

// Redirigir a la página de visualización de usuarios
header("Location: ../userV.php");
exit;
?>
