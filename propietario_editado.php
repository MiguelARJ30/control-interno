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

// Obtener el id del propietario desde la URL
$id_propietario = isset($_GET['id']) ? $_GET['id'] : 0;
$nombre = '';

if ($id_propietario) {
    try {
        // Obtener el nombre actual del propietario
        $sql = "SELECT nombre FROM propietario WHERE id_propietario = :id_propietario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_propietario' => $id_propietario]);
        $propietario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($propietario) {
            $nombre = $propietario['nombre'];
        } else {
            $error = 'Propietario no encontrado.';
        }
    } catch (PDOException $e) {
        $error = 'Error al obtener el propietario: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el nuevo nombre del formulario
    $nuevo_nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

    if ($nuevo_nombre) {
        try {
            // Actualizar el nombre en la base de datos
            $sql = "UPDATE propietario SET nombre = :nombre WHERE id_propietario = :id_propietario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['nombre' => $nuevo_nombre, 'id_propietario' => $id_propietario]);

            $success = 'El nombre del propietario se ha actualizado exitosamente.';
        } catch (PDOException $e) {
            $error = 'Error al actualizar el propietario: ' . $e->getMessage();
        }
    } else {
        $error = 'El nombre no puede estar vacío.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Propietario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Menú Principal</a>
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
                <h5 class="card-title">Editar Propietario</h5>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Propietario</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
