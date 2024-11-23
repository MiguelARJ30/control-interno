<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: index.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user']; // Obtener el nombre de usuario desde la sesión

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener todos los vehículos (carros) de la base de datos
$sql = "SELECT c.*, e.estado FROM carro c JOIN estado e ON c.id_estado = e.id_estado WHERE c.id_estado = 2";
$stmt = $pdo->query($sql);
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

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Color</th>
                    <th>Transmisión</th>
                    <th>Número de Motor</th>
                    <th>Número de Serie</th>
                    <th>Placas</th>
                    <th>Capacidad</th>
                    <th>Seguro</th>
                    <th>Circulación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <tr>
                        <td><?php echo $vehiculo['id_carro']; ?></td>
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
                            <td><?php echo htmlspecialchars($vehiculo['estado']); ?></td>
                        <td>
                            <!-- Botón de eliminar con confirmación -->
                            <a href="#" class="btn btn-primary btn-sm" onclick="confirmarEliminacion(<?php echo $vehiculo['id_carro']; ?>)">Activar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        </div>
    </div>

    <!-- Agregar la confirmación de eliminación -->
    <script>
        // Función para mostrar el mensaje de confirmación
        function confirmarEliminacion(id_carro) {
            // Mostrar mensaje de confirmación
            var confirmacion = confirm("¿Estás seguro de que deseas activar este vehículo?");

            if (confirmacion) {
                // Si el usuario confirma, redirigir a un script PHP que actualizará el estado
                window.location.href = "habilitar_carro.php?id=" + id_carro;
            }
        }
    </script>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
