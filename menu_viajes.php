<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: index.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user']; // Obtener el nombre de usuario desde la sesión
$id_puesto = $_SESSION['id_puesto'];

$roles = [
    1 => 'admin',      // id_puesto = 1 corresponde al rol "admin"
    2 => 'contaduria', // id_puesto = 2 corresponde al rol "contaduria"
    3 => 'operativa',  // id_puesto = 3 corresponde al rol "operativa"
    4 => 'juridico',   // id_puesto = 4 corresponde al rol "juridico"
    5 => 'sistemas'    // id_puesto = 5 corresponde al rol "sistemas"
];

$rol = $roles[$id_puesto] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Carro</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Asegura que el botón quede siempre en la parte inferior derecha */
        .btn-fixed {
            position: fixed;
            bottom: 40px;  /* Distancia desde el borde inferior */
            right: 40px;   /* Distancia desde el borde derecho */
            z-index: 9999; /* Para que quede encima de otros elementos */
        }
    </style>
</head>
<body>
    <!-- Header - Barra de navegación -->
    <nav class="navbar navbar-light" style="background-color: #472681;">
        <div class="container-fluid" style="display: flex; align-items: center; justify-content: center;">
            <img src="imagenes/trasla_2.png" alt="" width="160px" height="50px"></a>
        </div>
    </nav>

    <!-- Contenedor principal para las tarjetas -->
    <div class="container mt-4" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
    <div style="background-color: #472681; color: white; width: 300px; height: 50px; border-radius: 50px; display: flex; align-items: center; justify-content: center;">
        <p style="font-size: 26px;">TRABAJADOR</p>
    </div>
    <div class="row">
            <!-- Tarjetas -->
            <?php if ($rol == 'admin' || $rol == 'contaduria') : ?>
                <a class="btn btn-primary" href="convertir_archivo.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/agregar_carro.png" class="card-img-top" alt="Card image" style="width: 230px; height: 230px; margin: 1rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 170px; ">Viajes</h5>
                    </div>
                 </a>
            <?php endif; ?>
            <?php if ($rol == 'admin' || $rol == 'contaduria') : ?>
                <a class="btn btn-primary" href="documentos.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/agregar_carro.png" class="card-img-top" alt="Card image" style="width: 230px; height: 230px; margin: 1rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 170px; ">Documentos</h5>
                    </div>
                 </a>
            <?php endif; ?>
        
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
