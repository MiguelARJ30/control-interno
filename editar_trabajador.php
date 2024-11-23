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

// Obtener los datos de los trabajadores desde la base de datos
$sql = "SELECT t.*, e.estado FROM trabajador t JOIN estado e ON t.id_estado = e.id_estado ORDER BY t.id_trabajador ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Trabajadores</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center">Listado de Trabajadores</h5>

                <!-- Tabla de trabajadores -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Telefono</th>
                            <th>Fecha Alta</th>
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
                            <td><?php echo htmlspecialchars($trabajador['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($trabajador['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($trabajador['fecha_alta']); ?></td>
                            <td><?php echo htmlspecialchars($trabajador['correo']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['documento_curp']); ?>" target="_blank">CURP</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['credencial']); ?>" target="_blank">Credencial</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['comprobante_domicilio']); ?>" target="_blank">Domicilio</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['RFC']); ?>" target="_blank">RFC</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['lineamientos']); ?>" target="_blank">Lineamientos</a></td>
                            <td><a href="<?php echo htmlspecialchars($trabajador['contrato']); ?>" target="_blank">Contrato</a></td>
                            <td><?php echo htmlspecialchars($trabajador['estado']); ?></td>
                            <td>
                                <a href="trabajador_editado.php?id=<?php echo $trabajador['id_trabajador']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
