<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user']; // Obtener el nombre de usuario desde la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viajes</title>

    <!-- Enlace a la hoja de estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Menu carro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Bienvenido, <?php echo htmlspecialchars($usuario); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Menu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Sube tu archivo de viajes</h1>

        <!-- Formulario para cargar el archivo -->
        <div class="mb-3">
            <input type="file" id="file-input" class="form-control" />
        </div>

        <!-- Botones para cargar y descargar -->
        <div class="text-center mb-4">
            <button onclick="loadJSON()" class="btn btn-primary">Mostrar Datos</button>
            <button onclick="downloadExcel()" class="btn btn-success">Descargar como Excel</button>
        </div>

        <!-- Tabla para mostrar los datos -->
        <div class="table-responsive">
            <table id="data-table" class="table table-striped table-bordered mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>N.Viaje</th>
                        <th>Costo</th>
                        <th>Destino Dirección</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Método de Pago</th>
                        <th>Gana App</th>
                        <th>Gana Conductor</th>
                        <th>N.Semana</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
        let jsonData = {};

        // Función para cargar y mostrar los datos del archivo JSON
        function loadJSON() {
            const fileInput = document.getElementById('file-input');
            const file = fileInput.files[0];

            if (file && file.name.endsWith('.json')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    jsonData = JSON.parse(e.target.result);
                    displayData(jsonData);
                };
                reader.readAsText(file);
            } else {
                alert('Por favor selecciona un archivo JSON válido');
            }
        }

        // Función para mostrar los datos en una tabla
        function displayData(data) {
            const tableBody = document.querySelector('#data-table tbody');
            tableBody.innerHTML = ''; // Limpiar la tabla antes de agregar nuevos datos

            // Iterar sobre los elementos del JSON y agregarlos a la tabla
            for (const id in data) {
                if (data.hasOwnProperty(id)) {
                    const viajes = data[id].viajes;
                    for (const viajeId in viajes) {
                        const viaje = viajes[viajeId];
                        const row = document.createElement('tr');

                        // Asegúrate de que la fecha esté formateada adecuadamente
                        const fechaFormateada = new Date(viaje.fecha).toLocaleString();

                        row.innerHTML = `
                            <td>${id}</td> <!-- ID principal del viaje -->
                            <td>${viajeId}</td> <!-- ID del viaje -->
                            <td>${viaje.costo}</td>
                            <td>${viaje.destinoDireccion}</td>
                            <td>${viaje.estatus || 'N/A'}</td> <!-- Agregado 'estatus' con valor 'N/A' por si no existe -->
                            <td>${fechaFormateada}</td>
                            <td>${viaje.metodoPago}</td>
                            <td>${viaje.ganaApp}</td>
                            <td>${viaje.ganaConductor}</td>
                            <td>${viaje.idxSemana}</td> <!-- ID Semana -->
                        `;

                        tableBody.appendChild(row);
                    }
                }
            }
        }

        // Función para descargar la tabla como un archivo Excel
        function downloadExcel() {
            const table = document.getElementById('data-table');
            const wb = XLSX.utils.table_to_book(table, {sheet: 'Viajes'});
            XLSX.writeFile(wb, 'viajes.xlsx');
        }
    </script>

    <!-- Enlace a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
