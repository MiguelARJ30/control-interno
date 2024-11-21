<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$usuario = $_SESSION['user'];
include('conexion.php');

$error = '';
$propietarios = [];

// Verificar si hay un mensaje de estado en la URL
$status_message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $status_message = 'El propietario ha sido eliminado correctamente.';
    } elseif ($_GET['status'] == 'error') {
        $status_message = 'Hubo un error al intentar eliminar el propietario.';
    }
}

try {
    // Consulta con JOIN para obtener el nombre del estado
    $sql = "SELECT propietario.id_propietario, propietario.nombre, estado.estado 
    FROM propietario 
    JOIN estado ON propietario.id_estado = estado.id_estado
    WHERE propietario.id_estado = 2";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $propietarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Error al obtener los propietarios: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Propietarios</title>
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
                <h5 class="card-title">Lista de Propietarios</h5>

                <!-- Mostrar el mensaje de éxito o error si está presente -->
                <?php if ($status_message): ?>
                    <div class="alert alert-info"><?php echo $status_message; ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if (count($propietarios) > 0): ?>
                    <table class="table table-bordered table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Propietario</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($propietarios as $propietario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($propietario['id_propietario']); ?></td>
                                    <td><?php echo htmlspecialchars($propietario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($propietario['estado']); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarModal<?php echo $propietario['id_propietario']; ?>">Activar</button>
                                    </td>
                                </tr>

                                <!-- Modal de confirmación de eliminación -->
                                <div class="modal fade" id="eliminarModal<?php echo $propietario['id_propietario']; ?>" tabindex="-1" aria-labelledby="eliminarModalLabel<?php echo $propietario['id_propietario']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="eliminarModalLabel<?php echo $propietario['id_propietario']; ?>">Confirmar Activación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea activar este propietario?.
                                            </div>
                                            <div class="modal-footer">
                                                <form action="habilitar_propietario.php" method="POST">
                                                    <input type="hidden" name="id_propietario" value="<?php echo $propietario['id_propietario']; ?>">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Activar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">No se encontraron propietarios registrados.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
