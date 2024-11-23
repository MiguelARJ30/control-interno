<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$usuario = $_SESSION['user'];
include('conexion.php');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');

    if (empty($nombre)) {
        $error = 'El nombre del propietario es requerido.';
    } else {
        $sql = "INSERT INTO propietario (nombre, id_estado) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([$nombre, 1]); // El valor 1 es asignado a id_estado
    $success = 'Propietario registrado exitosamente.';
} catch (PDOException $e) {
    $error = 'Error al registrar el propietario: ' . $e->getMessage();
}
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Propietario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .center-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }
        .btn-fixed {
            position: fixed;
            bottom: 40px;  /* Distancia desde el borde inferior */
            right: 40px;   /* Distancia desde el borde derecho */
            z-index: 9999; /* Para que quede encima de otros elementos */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-light" style="background-color: #472681;">
        <div class="container-fluid" style="display: flex; align-items: center; justify-content: center;">
            <img src="imagenes/trasla_2.png" alt="" width="160px" height="50px"></a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-lg" style="border: 2px solid #472681; border-radius: 30px; padding: 3rem;">
            <div class="card-body">
                <h5 class="card-title" style="color: #472681;">Registro de Propietario</h5>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <!-- Formulario de registro de propietario -->
                <form action="registro_propietario.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Propietario</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" style="border-radius: 50px; border: 1px solid #472681;" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="border: none; background-color: #472681; border-radius: 50px;">Registrar Propietario</button>
                </form>
            </div>
        </div>
        <a class="btn btn-fixed" style="border-radius: 60%; borde: none;" href="menu_propietario.php">
                <img src="imagenes/atras.png" style="width: 85px;">
            </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
