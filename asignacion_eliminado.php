<?php
session_start(); // Inicia la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
$usuario = $_SESSION['user'];

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener los datos de asignaciones desde la base de datos
try {
    $sql = "SELECT a.*, c.placas AS placas_carro, d.nombre AS nombre_conductor, e.estado
            FROM asignacion a
            JOIN carro c ON a.id_carro = c.id_carro
            JOIN conductor d ON a.id_conductor = d.id_conductor
            JOIN estado e ON a.id_estado = e.id_estado
            WHERE a.id_estado = 1"; // Filtrar solo asignaciones con id_estado = 1
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error al cargar asignaciones: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Asignaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center">Listado de Asignaciones</h5>

                <!-- Tabla de asignaciones -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Carro</th>
                            <th>Conductor</th>
                            <th>Estado</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asignaciones as $asignacion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($asignacion['id_asignacion']); ?></td>
                            <td><?php echo htmlspecialchars($asignacion['placas_carro']); ?></td>
                            <td><?php echo htmlspecialchars($asignacion['nombre_conductor']); ?></td>
                            <td><?php echo htmlspecialchars($asignacion['estado']); ?></td>
                            <td><?php echo htmlspecialchars($asignacion['fecha_registro']); ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $asignacion['id_asignacion']; ?>, <?php echo $asignacion['id_carro']; ?>, <?php echo $asignacion['id_conductor']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta asignación?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" action="eliminar_asignacion.php" method="POST">
                        <input type="hidden" name="id_asignacion" id="id_asignacion">
                        <input type="hidden" name="id_carro" id="id_carro">
                        <input type="hidden" name="id_conductor" id="id_conductor">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        function confirmDelete(id_asignacion, id_carro, id_conductor) {
            document.getElementById('id_asignacion').value = id_asignacion;
            document.getElementById('id_carro').value = id_carro;
            document.getElementById('id_conductor').value = id_conductor;
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>
