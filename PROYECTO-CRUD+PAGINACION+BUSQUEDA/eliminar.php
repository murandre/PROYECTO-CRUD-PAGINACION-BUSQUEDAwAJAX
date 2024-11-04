<?php
require 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM videojuegos WHERE codigo_videojuego = $id";
if ($conn->query($sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>
