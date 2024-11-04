<?php
session_start();
$dir = "vistas/";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rockstarvideogames</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .poster {
            width: 100px; /* Cambia el tamaño según sea necesario */
            height: auto; /* Mantiene la proporción de la imagen */
        }
    </style>
</head>
<body>
    <header class="bg-light py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Rockstar Videojuegos</h1>
            <a href="DOM\index.html" class="btn btn-primary">DOM</a>
        </div>
    </header>

    <main>
        <div id="mensaje" class="alert alert-success d-none" role="alert"></div>

        <div class="container py-4">
            <h2 class="text-center">Videojuegos</h2>

            <div class="row g-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <label for="cod_videojuegos" class="col-form-label">Mostrar: </label>
                </div>
                <div class="col-auto">
                    <select name="cod_videojuegos" id="cod_videojuegos" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-auto">
                    <label for="cod_videojuegos" class="col-form-label">registros</label>
                </div>

                <div class="col-auto ms-auto">
                    <a href="crear.php" class="btn btn-success">Nuevo Videojuego</a>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4 col-xl-6"></div>
                <div class="col-md-2 text-end">
                    <label for="campo" class="col-form-label">Buscar: </label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="campo" id="campo" class="form-control">
                </div>
            </div>

            <div class="row py-4">
                <div class="col">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="sort asc">Cod. Videojuego</th>
                                <th class="sort asc">Fecha de salida</th>
                                <th class="sort asc">Título</th>
                                <th class="sort asc">Edad min.</th>
                                <th class="sort asc">Género</th>
                                <th>Poster</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="content"></tbody>
                    </table>
                </div>
            </div>

            <div class="row justify-content-between">
                <div class="col-12 col-md-4">
                    <label id="lbl-total"></label>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-center" id="nav-paginacion">
                    <!-- Aquí se generarán los botones de paginación -->
                </div>
                <input type="hidden" id="pagina" value="1">
                <input type="hidden" id="orderCol" value="0">
                <input type="hidden" id="orderType" value="asc">
            </div>
        </div>
    </main>

    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                let mensaje = document.getElementById('mensaje');
                mensaje.innerText = 'Videojuego creado exitosamente';
                mensaje.classList.remove('d-none');
            }
        }

        document.addEventListener("DOMContentLoaded", getData);

        function getData() {
            let input = document.getElementById("campo").value;
            let cod_videojuegos = document.getElementById("cod_videojuegos").value;
            let content = document.getElementById("content");
            let pagina = document.getElementById("pagina").value || 1;
            let orderCol = document.getElementById("orderCol").value;
            let orderType = document.getElementById("orderType").value;

            let formaData = new FormData();
            formaData.append('campo', input);
            formaData.append('registros', cod_videojuegos);
            formaData.append('pagina', pagina);
            formaData.append('orderCol', orderCol);
            formaData.append('orderType', orderType);

            fetch("load.php", {
                method: "POST",
                body: formaData
            })
                .then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data;
                    document.getElementById("lbl-total").innerHTML = `Mostrando ${data.limit} de ${data.totalRegistros} registros`;
                    

                    // Generar los botones de paginación
                    let paginationHTML = '';
                    let totalPaginas = Math.ceil(data.totalRegistros / cod_videojuegos);
                    for (let i = 1; i <= totalPaginas; i++) {
                        paginationHTML += `<button class="btn btn-outline-primary me-1" onclick="nextPage(${i})">${i}</button>`;
                    }
                    document.getElementById("nav-paginacion").innerHTML = paginationHTML;

                    if (data.data.includes('Sin resultados') && parseInt(pagina) !== 1) {
                        nextPage(1);
                    }
                })
                .catch(err => console.log(err));
        }

        function nextPage(pagina) {
            document.getElementById('pagina').value = pagina;
            getData();
        }

        function ordenar(e) {
            let elemento = e.target;
            let orderType = elemento.classList.contains("asc") ? "desc" : "asc";

            document.getElementById('orderCol').value = elemento.cellIndex;
            document.getElementById("orderType").value = orderType;
            elemento.classList.toggle("asc");
            elemento.classList.toggle("desc");

            getData();
        }

        document.getElementById("campo").addEventListener("keyup", getData);
        document.getElementById("cod_videojuegos").addEventListener("change", getData);

        let columns = document.querySelectorAll(".sort");
        columns.forEach(column => {
            column.addEventListener("click", ordenar);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
