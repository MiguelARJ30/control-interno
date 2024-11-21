<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user']; // Obtener el nombre de usuario desde la sesión
$id_puesto = $_SESSION['id_puesto'];

// Define un mapeo entre `id_puesto` y los roles
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
    <title>Menu</title>
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
<body style="background: white">
    <nav class="navbar navbar-light" style="background-color: #472681;">
        <div class="container-fluid" style="display: flex; align-items: center; justify-content: center;">
            <img src="imagenes/trasla_2.png" alt="" width="160px" height="50px"></a>
        </div>
    </nav>

    <!-- Contenedor principal para las tarjetas -->
    <div class="container mt-6" style="display: flex; aling-items: center; ">
        <div class="row">
        <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="menu_propietario.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/propietario.png" class="card-img-top" alt="Card image" style>
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 150px;">Propietario</h5>
                    </div>
                 </a>
            <?php endif; ?>

            <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="menu_carro.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/carro.png" class="card-img-top" alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 150px; ">Vehiculo</h5>
                    </div>
                 </a>
            <?php endif; ?>

            <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="menu_conductor.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/conductor.png" class="card-img-top" alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 150px; ">Conductor</h5>
                    </div>
                 </a>
            <?php endif; ?>

            <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="menu_asignacion.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/asignacion.png" class="card-img-top" alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 170px; ">Asignar carro</h5>
                    </div>
                 </a>
            <?php endif; ?>

            <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="menu_supervision.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/supervision.png" class="card-img-top" alt="Card image" style="width: 220px; height: 220px; margin: 1.5rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 150px; ">Supervision</h5>
                    </div>
                 </a>
            <?php endif; ?>

            <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="menu_trabajador.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/trabajador.png" class="card-img-top" alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 150px; ">Trabajador</h5>
                    </div>
                 </a>
            <?php endif; ?>

            <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="menu_viajes.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/viaje.png" class="card-img-top" alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 150px; ">Viajes</h5>
                    </div>
                 </a>
            <?php endif; ?>

            <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="#" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/carpeta.png" class="card-img-top" alt="Card image" style="width: 220px; height: 220px; margin: 1.5rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 150px; ">Expedientes</h5>
                    </div>
                 </a>
            <?php endif; ?>

            <?php if ($rol == 'admin' || $rol == 'operativa') : ?>
                <a class="btn btn-primary" href="menu_usuario.php" style="width: 300px; height: 350px; border-radius: 50px; background-color: white; border: 3px solid #472681; margin: 4rem; display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <img src="imagenes/usuario.png" class="card-img-top" alt="Card image" style="width: 220px; height: 220px; margin: 1.5rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white; font-size: 24px; background-color: #472681; border-radius: 50px; width: 150px; ">Usuarios</h5>
                    </div>
                 </a>
            <?php endif; ?>
        </div>
    </div>
    <a class="btn btn-fixed" style="border-radius: 60%; borde: none;" href="logout.php">
        <img src="imagenes/cerrar-sesion.png" style="width: 85px;">
    </a>
    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
