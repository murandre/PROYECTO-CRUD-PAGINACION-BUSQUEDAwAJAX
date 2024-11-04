<?php
require 'config.php';

$columns = ['codigo_videojuego', 'fecha_salida', 'titulo', 'edad_minima', 'genero'];
$table = "videojuegos";
$dir = "vistas/";

$id = 'codigo_videojuego';
$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;

$where = '';
if ($campo != null) {
    $where = "WHERE (" . implode(' OR ', array_map(function ($column) use ($campo) {
        return "$column LIKE '%$campo%'";
    }, $columns)) . ")";
}

$limit = isset($_POST['registros']) ? intval($_POST['registros']) : 10; // Convertir a entero
$pagina = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1; // Convertir a entero
$inicio = ($pagina - 1) * $limit;
$sLimit = "LIMIT $inicio, $limit";

$sOrder = '';
if (isset($_POST['orderCol']) && isset($_POST['orderType'])) {
    $orderCol = intval($_POST['orderCol']);
    $orderType = $_POST['orderType'] === 'desc' ? 'desc' : 'asc'; // Asegurarse de que solo sean 'asc' o 'desc'
    if (isset($columns[$orderCol])) {
        $sOrder = "ORDER BY {$columns[$orderCol]} $orderType";
    }
}

$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . " FROM $table $where $sOrder $sLimit";
$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

$num_rows = $resultado->num_rows;

$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$totalFiltro = $resFiltro->fetch_array()[0];

$sqlTotal = "SELECT COUNT($id) FROM $table";
$resTotal = $conn->query($sqlTotal);
$totalRegistros = $resTotal->fetch_array()[0];

$output = [
    'totalRegistros' => $totalRegistros,
    'totalFiltro' => $totalFiltro,
    'data' => '',
    'limit' => $limit // Agregar esta línea para incluir el límite en la respuesta
];

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td>' . htmlspecialchars($row['codigo_videojuego']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['fecha_salida']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['titulo']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['edad_minima']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['genero']) . '</td>';
        $output['data'] .= '<td><img src="' . htmlspecialchars($dir . $row['codigo_videojuego'] . '.jpg') . '" class="poster img-fluid"></td>';
        $output['data'] .= '<td><a href="editar.php?id=' . htmlspecialchars($row['codigo_videojuego']) . '" class="btn btn-warning">Editar</a></td>';
        $output['data'] .= '<td><a href="eliminar.php?id=' . htmlspecialchars($row['codigo_videojuego']) . '" class="btn btn-danger">Eliminar</a></td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr><td colspan="8">Sin resultados</td></tr>';
}

echo json_encode($output);
