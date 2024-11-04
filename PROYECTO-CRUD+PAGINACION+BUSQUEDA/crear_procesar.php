<?php
require 'config.php';

// Verificar que todos los campos necesarios estén presentes
if (empty($_POST['titulo']) ||
    empty($_POST['fecha_salida']) ||
    empty($_POST['edad_minima']) ||
    empty($_POST['genero'])) {
    die("Error: Todos los campos son obligatorios");
}

// Asegurarse de que la conexión a la base de datos esté activa
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Sanitizar entradas
$titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
$fecha_salida = mysqli_real_escape_string($conn, $_POST['fecha_salida']);
$edad_minima = mysqli_real_escape_string($conn, $_POST['edad_minima']);
$genero = mysqli_real_escape_string($conn, $_POST['genero']);

// Crear la consulta de inserción
$sql = "INSERT INTO videojuegos (titulo, fecha_salida, edad_minima, genero) VALUES ('$titulo', '$fecha_salida', '$edad_minima', '$genero')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    // Manejar la carga de la imagen
    $codigo_videojuego = $conn->insert_id; // Obtener el ID del nuevo videojuego
    if (isset($_FILES['vista']) && $_FILES['vista']['error'] === UPLOAD_ERR_OK) {
        $dir = "vistas/";
        $vista = $dir . $codigo_videojuego . '.jpg';
        if (move_uploaded_file($_FILES['vista']['tmp_name'], $vista)) {
            echo "Imagen subida correctamente.";
        } else {
            echo "Error al mover la imagen.";
        }
    }
    header("Location: index.php?status=created");
} else {
    die("Error: " . $conn->error);
}
?>
