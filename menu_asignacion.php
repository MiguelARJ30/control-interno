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
    <title>Menu asignacion</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header - Barra de navegación -->
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

    <!-- Contenedor principal para las tarjetas -->
    <div class="container mt-4">
        <div class="row">
            <!-- Tarjetas -->
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 300px; height: 350px;">
                    <!-- <img src="imagenes/agregar_carro.png" class="card-img-top" alt="Card image" style="width: 250px; height: 250px;"> -->
                    <div class="card-body">
                        <h5 class="card-title">Registrar asignación</h5>
                        <a href="registro_asignacion.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 300px; height: 350px;">
                    <!-- <img src="imagenes/ver_datos.png" class="card-img-top" alt="Card image" style="width: 250px; height: 250px;"> -->
                    <div class="card-body">
                        <h5 class="card-title">Ver Asignaciones</h5>
                        <a href="ver_asignacion.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card" style="width: 300px; height: 350px;">
                    <!-- <img src="imagenes/habilitar.png" class="card-img-top" alt="Card image" style="width: 250px; height: 250px;"> -->
                    <div class="card-body">
                        <h5 class="card-title">Eliminar Asignacion</h5>
                        <a href="asignacion_eliminado.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
