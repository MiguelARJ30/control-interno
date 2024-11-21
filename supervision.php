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

// Obtener las asignaciones registradas en la base de datos, con la información de carro y conductor
$query = "SELECT a.id_asignacion, c.placas, d.nombre
FROM asignacion a 
JOIN carro c ON a.id_carro = c.id_carro
JOIN conductor d ON a.id_conductor = d.id_conductor
WHERE a.id_estado = 1";
$stmt = $pdo->query($query);
$asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener el id_inventario de la URL si existe
$id_inventario = isset($_GET['id_inventario']) ? htmlspecialchars($_GET['id_inventario']) : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Asignación</title>
    <!-- Incluir Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Formulario de Asignación</h2>
        <form action="procesar_asignacion.php?id_inventario=<?= $id_inventario ?>" method="POST" enctype="multipart/form-data">
            <!-- Select para asignación -->
            <div class="mb-3">
                <label for="asignacion" class="form-label">Selecciona una Asignación</label>
                <select id="asignacion" name="asignacion" class="form-select" required>
                    <option value="" disabled selected>Elige una asignación</option>
                    <?php foreach ($asignaciones as $asignacion): ?>
                        <option value="<?= htmlspecialchars($asignacion['id_asignacion']) ?>">
                            <?= htmlspecialchars($asignacion['placas']) . " - " . htmlspecialchars($asignacion['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="id_inventario" value="<?= htmlspecialchars($id_inventario) ?>">
            <!-- Subida de documentos de inventario -->
            <div class="mb-3">
                <label for="inventario" class="form-label">Subir Inventario</label>
                <input type="file" id="inventario" name="inventario" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                <small class="form-text text-muted">Sube el documento relacionado con el inventario (PDF, JPG, PNG).</small>
            </div>

            <!-- Subida de documentos de reporte -->
            <div class="mb-3">
                <label for="reporte" class="form-label">Subir Reporte</label>
                <input type="file" id="reporte" name="reporte" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                <small class="form-text text-muted">Sube el reporte correspondiente (PDF, JPG, PNG).</small>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Guardar Asignación</button>
        </form>
    </div>

    <!-- Incluir el JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
