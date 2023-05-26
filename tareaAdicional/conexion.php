<?php
$servername = "localhost";
$username = "root";
$password = "5160129802";
$dbname = "tarea";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
