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

// Obtener todos los conductores activos (id_estado = 1)
$sql = "SELECT c.*, e.estado FROM trabajador c JOIN estado e ON c.id_estado = e.id_estado WHERE c.id_estado = 2";
$stmt = $pdo->query($sql);
$trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th>#</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>CURP</th>
                            <th>Credencial</th>
                            <th>Domicilio</th>
                            <th>RFC</th>
                            <th>Lineamientos</th>
                            <th>Contrato</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trabajadores as $trabajador): ?>
                            <tr>
                            <td><?php echo htmlspecialchars($trabajador['id_trabajador']); ?></td>
                            <td><?php echo htmlspecialchars($trabajador['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($trabajador['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($trabajador['correo']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['documento_curp']); ?>" target="_blank">CURP</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['credencial']); ?>" target="_blank">Credencial</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['comprobante_domicilio']); ?>" target="_blank">Comprobante</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['RFC']); ?>" target="_blank">RFC</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['lineamientos']); ?>" target="_blank">Lineamientos</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['contrato']); ?>" target="_blank">Contrato</a></td>
                            <td><?php echo htmlspecialchars($trabajador['estado']); ?></td>
                                <td>
                                    <!-- Botón de eliminar con confirmación -->
                                    <a href="#" class="btn btn-primary btn-sm" onclick="confirmarEliminacion(<?php echo $trabajador['id_trabajador']; ?>)">Activar</a>
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
        function confirmarEliminacion(id_trabajador) {
            // Mostrar mensaje de confirmación
            var confirmacion = confirm("¿Estás seguro de que deseas activar este conductor?");

            if (confirmacion) {
                // Si el usuario confirma, redirigir a un script PHP que actualizará el estado
                window.location.href = "habilitar_trabajador.php?id=" + id_trabajador;
            }
        }
    </script>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
