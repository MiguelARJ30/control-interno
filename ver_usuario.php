<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
$usuario = $_SESSION['user'];
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Consultar los datos de la tabla usuarios
$sqlUsuarios = "SELECT 
        usuarios.id_usuario,
        usuarios.usuario,
        usuarios.password,
        usuarios.fecha_creacion,
        puesto.puesto AS puesto,
        trabajador.nombre AS trabajador,
        estado.estado AS estado
    FROM 
        usuarios
    LEFT JOIN puesto ON usuarios.id_puesto = puesto.id_puesto
    LEFT JOIN trabajador ON usuarios.id_trabajador = trabajador.id_trabajador
    LEFT JOIN estado ON usuarios.id_estado = estado.id_estado
";
$stmtUsuarios = $pdo->query($sqlUsuarios);
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
    <!-- Vincular Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Usuarios Registrados</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID Usuario</th>
                        <th>Usuario</th>
                        <th>Fecha de Creación</th>
                        <th>ID Puesto</th>
                        <th>ID Trabajador</th>
                        <th>ID Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                                <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                                <td><?= htmlspecialchars($usuario['fecha_creacion']) ?></td>
                                <td><?= htmlspecialchars($usuario['puesto']) ?></td>
                                <td><?= htmlspecialchars($usuario['trabajador']) ?></td>
                                <td><?= htmlspecialchars($usuario['estado']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Vincular Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
