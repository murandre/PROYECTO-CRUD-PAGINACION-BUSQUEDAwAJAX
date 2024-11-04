<?php
require 'config.php';

// Verificar que el código de videojuego y otros campos estén presentes y no vacíos
if (empty($_POST['codigo_videojuego']) ||
    empty($_POST['fecha_salida']) ||
    empty($_POST['titulo']) ||
    empty($_POST['edad_minima']) ||
    empty($_POST['genero'])) {
    die("Error: Todos los campos son obligatorios");
}

$codigo_videojuego = $_POST['codigo_videojuego'];
$fecha_salida = mysqli_real_escape_string($conn, $_POST['fecha_salida']);
$titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
$edad_minima = mysqli_real_escape_string($conn, $_POST['edad_minima']);
$genero = mysqli_real_escape_string($conn, $_POST['genero']);

// Crear la consulta de actualización
$sql = "UPDATE videojuegos SET 
        fecha_salida = '$fecha_salida',
        titulo = '$titulo',
        edad_minima = '$edad_minima',
        genero = '$genero'
        WHERE codigo_videojuego = '$codigo_videojuego'";

// Ejecutar la consulta
if ($conn->query($sql)) {
    // Manejar la carga de la imagen si se ha subido
    if (isset($_FILES['vista']) && $_FILES['vista']['error'] === UPLOAD_ERR_OK) { // Cambiar 'poster' a 'vista'
        $dir = "vistas/";
        $vista = $dir . $codigo_videojuego . '.jpg';
        if (move_uploaded_file($_FILES['vista']['tmp_name'], $vista)) {
            echo "Imagen actualizada correctamente.";
        } else {
            echo "Error al mover la imagen.";
        }
    }
    header("Location: index.php?status=updated");
} else {
    die("Error: " . $conn->error);
}
