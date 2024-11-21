<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user']; // Obtener el nombre de usuario desde la sesión

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener todos los vehículos (carros) de la base de datos
$sql = "SELECT c.*, e.estado FROM conductor c JOIN estado e ON c.id_estado = e.id_estado WHERE c.id_estado = 2";
$stmt = $pdo->query($sql);
$conductores = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h5 class="card-title text-center">Listado de Conductores</h5>

        <table class="table table-striped">
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
            <?php foreach ($conductores as $conductor): ?>
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
                            <!-- Botón de eliminar con confirmación -->
                            <a href="#" class="btn btn-primary btn-sm" onclick="confirmarEliminacion(<?php echo $conductor['id_conductor']; ?>)">Activar</a>
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
        function confirmarEliminacion(id_conductor) {
            // Mostrar mensaje de confirmación
            var confirmacion = confirm("¿Estás seguro de que deseas activar este conductor?");

            if (confirmacion) {
                // Si el usuario confirma, redirigir a un script PHP que actualizará el estado
                window.location.href = "habilitar_conductor.php?id=" + id_conductor;
            }
        }
    </script>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
