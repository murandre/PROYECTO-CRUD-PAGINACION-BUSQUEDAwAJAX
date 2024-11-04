<?php

$conn = new mysqli("127.0.0.1", "root", "", "rockstarvideogames");

if ($conn->connect_error) {
    echo 'Error de conexion ' . $conn->connect_error;
    exit;
}
