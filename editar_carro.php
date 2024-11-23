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

// Modificar la consulta para incluir el nombre del tipo y del propietario
$sql = "SELECT c.*, e.estado, t.tipo_nombre, p.nombre AS propietario_nombre 
        FROM carro c 
        JOIN estado e ON c.id_estado = e.id_estado
        JOIN tipo t ON c.id_tipos = t.id_tipo
        JOIN propietario p ON c.id_propietario = p.id_propietario";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Vehículos</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center">Listado de Vehículos</h5>

                <!-- Tabla de vehículos -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Carro / Moto</th>
                            <th>Tipo</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Color</th>
                            <th>Transmisión</th>
                            <th>N. Motor</th>
                            <th>N. Serie</th>
                            <th>Placas</th>
                            <th>Capacidad</th>
                            <th>Seguro</th>
                            <th>Circulación</th>
                            <th>Propietario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vehiculos as $vehiculo): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($vehiculo['tipo_nombre']); ?></td> <!-- Mostrar el nombre del tipo -->
                            <td><?php echo htmlspecialchars($vehiculo['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['marca']); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['color']); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['transmision']); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['n_motor']); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['n_serie']); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['placas']); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['capacidad']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($vehiculo['seguro']); ?>" target="_blank">Ver Seguro</a></td>
                            <td><a href="<?php echo htmlspecialchars($vehiculo['circulacion']); ?>" target="_blank">Ver Circulación</a></td>
                            <td><?php echo htmlspecialchars($vehiculo['propietario_nombre']); ?></td> <!-- Mostrar el nombre del propietario -->
                            <td><?php echo htmlspecialchars($vehiculo['estado']); ?></td>
                            <td>
                                <a href="carro_editado.php?id=<?php echo $vehiculo['id_carro']; ?>" class="btn btn-warning btn-sm">Editar</a>
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
