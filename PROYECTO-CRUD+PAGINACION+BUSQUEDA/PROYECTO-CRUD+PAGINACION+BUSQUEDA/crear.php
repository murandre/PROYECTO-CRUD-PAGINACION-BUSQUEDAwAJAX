<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Videojuego</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Crear Nuevo Videojuego</h2>
        <form action="crear_procesar.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="fecha_salida" class="form-label">Fecha de salida</label>
                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
            </div>
            <div class="mb-3">
                <label for="edad_minima" class="form-label">Edad mínima</label>
                <input type="number" class="form-control" id="edad_minima" name="edad_minima" required>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="" disabled selected>Seleccione un género</option>
                    <option value="Acción">Acción</option>
                    <option value="Aventura">Aventura</option>
                    <option value="RPG">RPG</option>
                    <option value="Deportes">Deportes</option>
                    <option value="Simulación">Simulación</option>
                    <option value="Estrategia">Estrategia</option>
                    <option value="Plataformas">Plataformas</option>
                    <option value="Puzzle">Puzzle</option>
                    <option value="Horror">Horror</option>
                    <option value="Indie">Indie</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="vista" class="form-label">Vista Pista:</label>
                <input type="file" name="vista" id="vista" class="form-control" accept="image/jpg">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>

</html>
