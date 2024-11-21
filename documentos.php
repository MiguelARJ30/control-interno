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
  <title>Documentos</title>
  <!-- Vincula los estilos de Bootstrap desde un CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 20px;
    }
    table th, table td {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Sube tu archivo JSON</h1>

    <!-- Formulario para subir archivo -->
    <div class="mb-3">
      <input type="file" id="jsonFile" class="form-control"/>
      <button onclick="readFile()" class="btn btn-primary mt-3">Subir JSON</button>
    </div>

    <!-- Tabla para mostrar los datos -->
    <h2 class="text-center mb-4">Datos del JSON</h2>
    <table class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Usuario</th>
          <th>Documento</th>
          <th>Nombre</th>
          <th>Estado</th>
          <th>Imagen</th>
        </tr>
      </thead>
      <tbody id="dataTable">
        <!-- Aquí se mostrarán los datos -->
      </tbody>
    </table>
  </div>

  <!-- Vincula los scripts de Bootstrap y JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    function readFile() {
      const fileInput = document.getElementById('jsonFile');
      const file = fileInput.files[0];

      if (!file) {
        alert("Por favor, selecciona un archivo.");
        return;
      }

      const reader = new FileReader();

      reader.onload = function(event) {
        const jsonData = JSON.parse(event.target.result);
        const tableBody = document.querySelector("#dataTable");
        tableBody.innerHTML = ""; // Limpiar tabla antes de mostrar los nuevos datos

        // Recorrer cada usuario en el JSON
        for (const userKey in jsonData) {
          if (jsonData.hasOwnProperty(userKey)) {
            const userDocuments = jsonData[userKey].documentos;

            // Recorrer los documentos de cada usuario
            for (const docKey in userDocuments) {
              if (userDocuments.hasOwnProperty(docKey)) {
                const docData = userDocuments[docKey];
                const row = document.createElement("tr");

                // Columna: Usuario
                const userCell = document.createElement("td");
                userCell.textContent = userKey; // El nombre del usuario
                row.appendChild(userCell);

                // Columna: Documento
                const docCell = document.createElement("td");
                docCell.textContent = docKey; // ID del documento
                row.appendChild(docCell);

                // Columna: Nombre
                const nameCell = document.createElement("td");
                nameCell.textContent = docData.nombre;
                row.appendChild(nameCell);

                // Columna: Estado
                const statusCell = document.createElement("td");
                statusCell.textContent = docData.estatus;
                row.appendChild(statusCell);

                // Columna: Imagen
                const imageCell = document.createElement("td");
                const imageLink = document.createElement("a");
                imageLink.href = docData.imagenUrl;
                imageLink.textContent = "Ver Imagen";
                imageLink.target = "_blank";
                imageCell.appendChild(imageLink);
                row.appendChild(imageCell);

                // Agregar la fila a la tabla
                tableBody.appendChild(row);
              }
            }
          }
        }
      };

      reader.readAsText(file);
    }
  </script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
