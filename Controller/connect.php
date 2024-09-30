<?php
$serverName = "192.168.5.2"; 
$connectionInfo = array(
    "Database" => "MiradaVerde", 
    "UID" => "SysMariano", 
    "PWD" => "Niidea00", 
    "TrustServerCertificate" => "yes"
);

$conn = sqlsrv_connect($serverName, $connectionInfo);

// Verifica si la conexión fue exitosa
if ($conn === false) {
    // Si la conexión falla, imprime los errores
    die("Conexión fallida: " . print_r(sqlsrv_errors(), true));
} else {
    echo "Conexión exitosa a la base de datos 'MiradaVerde'.";
}

?>