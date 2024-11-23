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

// Obtener los datos de los vehículos desde la base de datos
$sql = "SELECT c.*, e.estado FROM conductor c JOIN estado e ON c.id_estado = e.id_estado";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$conductor = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Conductores</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center">Listado de Conductores</h5>

                <!-- Tabla de vehículos -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>#</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Telefono</th>
                            <th>Fecha</th>
                            <th>Licencia</th>
                            <th>Credencial</th>
                            <th>Comprobante</th>
                            <th>CURP</th>
                            <th>RFC</th>
                            <th>Lineamientos</th>
                            <th>Contrato</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($conductor as $conductor): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($conductor['id_conductor']); ?></td>
                            <td><?php echo htmlspecialchars($conductor['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($conductor['Direccion']); ?></td>
                            <td><?php echo htmlspecialchars($conductor['Telefono']); ?></td>
                            <td><?php echo htmlspecialchars($conductor['Fecha_alta']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($conductor['Licencia']); ?>" target="_blank">Ver Licencia</a></td>
                            <td><a href="<?php echo htmlspecialchars($conductor['credencial']); ?>" target="_blank">Ver Credencial</a></td>
                            <td><a href="<?php echo htmlspecialchars($conductor['Comprobante_domicilio']); ?>" target="_blank">Ver Comprobante</a></td>
                            <td><a href="<?php echo htmlspecialchars($conductor['CURP']); ?>" target="_blank">Ver CURP</a></td>
                            <td><a href="<?php echo htmlspecialchars($conductor['RFC']); ?>" target="_blank">Ver RFC</a></td>
                            <td><a href="<?php echo htmlspecialchars($conductor['Lineamientos']); ?>" target="_blank">Ver Lineamientos</a></td>
                            <td><a href="<?php echo htmlspecialchars($conductor['Contrato']); ?>" target="_blank">Ver Contrato</a></td>
                            <td><?php echo htmlspecialchars($conductor['estado']); ?></td>
                            <td>
                                <a href="conductor_editado.php?id=<?php echo $conductor['id_conductor']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Botón para agregar un nuevo vehículo -->
            </div>
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
