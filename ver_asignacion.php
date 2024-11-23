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
$sql = "SELECT a.*, c.placas AS placas_carro, d.nombre AS nombre_conductor, e.estado
        FROM asignacion a
        JOIN carro c ON a.id_carro = c.id_carro
        JOIN conductor d ON a.id_conductor = d.id_conductor
        JOIN estado e ON a.id_estado = e.id_estado";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Asignaciones</title>
    <!-- Vinculando Bootstrap CSS -->
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
                            <th>Fecha de Registro</th> <!-- Nueva columna para la fecha de registro -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asignaciones as $asignacion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($asignacion['id_asignacion']); ?></td>
                            <td><?php echo htmlspecialchars($asignacion['placas_carro']); ?></td>
                            <td><?php echo htmlspecialchars($asignacion['nombre_conductor']); ?></td>
                            <td><?php echo htmlspecialchars($asignacion['estado']); ?></td>
                            <td><?php echo htmlspecialchars($asignacion['fecha_registro']); ?></td> <!-- Mostrar la fecha de registro -->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Botón para agregar una nueva asignación -->
            </div>
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
