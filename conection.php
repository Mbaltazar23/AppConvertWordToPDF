<?php

// Configurar la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_prueba";

$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>