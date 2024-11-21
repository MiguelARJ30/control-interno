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
    <title>Menu Carro</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header - Barra de navegación -->
    <nav class="navbar navbar-light" style="background-color: #472681;">
        <div class="container-fluid" style="display: flex; align-items: center; justify-content: center;">
            <a class="navbar-brand" href="#">
            <img src="imagenes/trasla_2.png" alt="" width="160px" height="50px"></a>
        </div>
    </nav>

    <!-- Contenedor principal para las tarjetas -->
    <div class="container mt-4">
        <div class="row">
            <!-- Tarjetas -->
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 300px; height: 350px;">
                    <!-- <img src="imagenes/agregar_carro.png" class="card-img-top" alt="Card image" style="width: 250px; height: 250px;"> -->
                    <div class="card-body">
                        <h5 class="card-title">Registrar Supervisión</h5>
                        <a href="registrar_supervision.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 300px; height: 350px;">
                    <!-- <img src="imagenes/ver_datos.png" class="card-img-top" alt="Card image" style="width: 250px; height: 250px;"> -->
                    <div class="card-body">
                        <h5 class="card-title">Ver Supervisiónes</h5>
                        <a href="listado_supervision.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
            
            <!-- <div class="col-md-4 mb-4">
                <div class="card" style="width: 300px; height: 350px;">
                    <img src="imagenes/editar_datos.png" class="card-img-top" alt="Card image" style="width: 250px; height: 250px;">
                    <div class="card-body">
                        <h5 class="card-title">Editar Supervisiónes</h5>
                        <a href="editar_supervision.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
