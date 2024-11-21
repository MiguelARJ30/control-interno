<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Menú Principal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Bienvenido, <?php echo htmlspecialchars($usuario); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title">Registro de Propietario</h5>

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
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Propietario</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
