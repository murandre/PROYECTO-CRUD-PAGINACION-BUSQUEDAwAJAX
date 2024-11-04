<?php
require 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM videojuegos WHERE codigo_videojuego = $id";
$resultado = $conn->query($sql);
$videojuego = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Videojuego</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Editar Videojuego</h2>
        <form action="editar_procesar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="codigo_videojuego" value="<?= $videojuego['codigo_videojuego'] ?>">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $videojuego['titulo'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_salida" class="form-label">Fecha de salida</label>
                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" value="<?= $videojuego['fecha_salida'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="edad_minima" class="form-label">Edad mínima</label>
                <input type="number" class="form-control" id="edad_minima" name="edad_minima" value="<?= $videojuego['edad_minima'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="genero" class="form-label">Género</label>
                    <select class="form-select" id="genero" name="genero" required>
                        <option value="" disabled>Seleccione un género</option>
                        <option value="Acción" <?= $videojuego['genero'] == 'Acción' ? 'selected' : '' ?>>Acción</option>
                        <option value="Aventura" <?= $videojuego['genero'] == 'Aventura' ? 'selected' : '' ?>>Aventura</option>
                        <option value="RPG" <?= $videojuego['genero'] == 'RPG' ? 'selected' : '' ?>>RPG</option>
                        <option value="Deportes" <?= $videojuego['genero'] == 'Deportes' ? 'selected' : '' ?>>Deportes</option>
                        <option value="Simulación" <?= $videojuego['genero'] == 'Simulación' ? 'selected' : '' ?>>Simulación</option>
                        <option value="Estrategia" <?= $videojuego['genero'] == 'Estrategia' ? 'selected' : '' ?>>Estrategia</option>
                        <option value="Plataformas" <?= $videojuego['genero'] == 'Plataformas' ? 'selected' : '' ?>>Plataformas</option>
                        <option value="Puzzle" <?= $videojuego['genero'] == 'Puzzle' ? 'selected' : '' ?>>Puzzle</option>
                        <option value="Horror" <?= $videojuego['genero'] == 'Horror' ? 'selected' : '' ?>>Horror</option>
                        <option value="Indie" <?= $videojuego['genero'] == 'Indie' ? 'selected' : '' ?>>Indie</option>
                </select>
            </div>

            <div class="mb-3">
              <img id="img_vista" width="100">
            </div>

            <div class="mb-3">
                <label for="vista" class="form-label">Poster:</label>
                <input type="file" name="vista" id="vista" class="form-control" accept="image/jpg">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</body>

</html>
