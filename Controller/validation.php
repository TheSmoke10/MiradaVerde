<?php
session_start(); // Inicia la sesión

// Conexión a la base de datos
include("connect.php");

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar las credenciales y obtener el ID del usuario
    $query = "SELECT IdUser, Password FROM [dbo].[user] WHERE Correo = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Verifica si el usuario existe
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Verifica la contraseña
        if (password_verify($password, $row['Password'])) {
            // Almacena el ID del usuario en la sesión y redirige al menú
            $_SESSION['user_id'] = $row['IdUser']; // Cambiado a almacenar el ID del usuario
            header("Location: ../menu.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
            header("Location: ../login.php");
        }
    } else {
        $error = "El correo no está registrado.";
        header("Location: ../login.php");
    }

    // Cierra la conexión
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    header("Location: ../login.php");
}
?>
