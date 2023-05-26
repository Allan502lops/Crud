<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    $sql = "DELETE FROM producto WHERE id_producto = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}

$conn->close();
?>
