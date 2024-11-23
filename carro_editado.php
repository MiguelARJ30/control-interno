<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
$usuario = $_SESSION['user'];

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si se ha pasado un ID de carro
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si no se pasa el ID, redirigir a la lista de vehículos
    header('Location: listado_carros.php');
    exit;
}

$id_carro = $_GET['id'];

// Obtener los datos del vehículo para editar
$sql = "SELECT c.*, e.estado FROM carro c JOIN estado e ON c.id_estado = e.id_estado WHERE c.id_carro = :id_carro";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_carro', $id_carro);
$stmt->execute();
$vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener todos los tipos de vehículos
$sql_tipos = "SELECT * FROM tipo";
$stmt_tipos = $pdo->prepare($sql_tipos);
$stmt_tipos->execute();
$tipos = $stmt_tipos->fetchAll(PDO::FETCH_ASSOC);

// Obtener todos los propietarios
$sql_propietarios = "SELECT * FROM propietario";
$stmt_propietarios = $pdo->prepare($sql_propietarios);
$stmt_propietarios->execute();
$propietarios = $stmt_propietarios->fetchAll(PDO::FETCH_ASSOC);


// Verificar si se encuentra el vehículo
if (!$vehiculo) {
    // Si no se encuentra el vehículo, redirigir a la lista
    header('Location: listado_carros.php');
    exit;
}

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $id_tipo = $_POST['id_tipos'];
    $id_propietario = $_POST['id_propietario'];
    $tipo = $_POST['tipo'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $color = $_POST['color'];
    $transmision = $_POST['transmision'];
    $n_motor = $_POST['n_motor'];
    $n_serie = $_POST['n_serie'];
    $placas = $_POST['placas'];
    $capacidad = $_POST['capacidad'];
    $id_estado = $_POST['id_estado'];

    // Validar archivos y subirlos si son nuevos
    $seguroPath = $vehiculo['seguro'];
    $circulacionPath = $vehiculo['circulacion'];

    if ($_FILES['seguro']['name']) {
        $seguroPath = 'conductores/' . $_POST['placas'] . '_seguro.' . pathinfo($_FILES['seguro']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['seguro']['tmp_name'], $seguroPath);
    }

    if ($_FILES['circulacion']['name']) {
        $circulacionPath = 'conductores/' . $_POST['placas'] . '_circulacion.' . pathinfo($_FILES['circulacion']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['circulacion']['tmp_name'], $circulacionPath);
    }

    // Actualizar los datos en la base de datos
    $sql_update = "UPDATE carro SET 
        id_tipos = :id_tipos,
        id_propietario = :id_propietario,
        tipo = :tipo, 
        modelo = :modelo, 
        marca = :marca, 
        color = :color, 
        transmision = :transmision, 
        n_motor = :n_motor, 
        n_serie = :n_serie, 
        placas = :placas, 
        capacidad = :capacidad, 
        seguro = :seguro, 
        circulacion = :circulacion, 
        id_estado = :id_estado 
        WHERE id_carro = :id_carro";

    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([
        ':id_tipos' => $id_tipo,
        ':id_propietario' => $id_propietario,
        ':tipo' => $tipo,
        ':modelo' => $modelo,
        ':marca' => $marca,
        ':color' => $color,
        ':transmision' => $transmision,
        ':n_motor' => $n_motor,
        ':n_serie' => $n_serie,
        ':placas' => $placas,
        ':capacidad' => $capacidad,
        ':seguro' => $seguroPath,
        ':circulacion' => $circulacionPath,
        ':id_estado' => $id_estado,
        ':id_carro' => $id_carro
    ]);

    $success = 'Vehículo actualizado exitosamente.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vehículo</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center">Editar Vehículo</h5>

                <!-- Mostrar mensaje de éxito -->
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <!-- Formulario de edición de vehículo -->
                <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
    <label for="id_tipos" class="form-label">Tipo de Vehículo</label>
    <select class="form-control" id="id_tipos" name="id_tipos" required>
        <option value="">Seleccione un tipo</option>
        <?php foreach ($tipos as $tipo): ?>
            <option value="<?php echo $tipo['id_tipo']; ?>" 
                <?php echo ($tipo['id_tipo'] == $vehiculo['id_tipos']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($tipo['tipo_nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo htmlspecialchars($vehiculo['tipo']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo htmlspecialchars($vehiculo['modelo']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" value="<?php echo htmlspecialchars($vehiculo['marca']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="color" name="color" value="<?php echo htmlspecialchars($vehiculo['color']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="transmision" class="form-label">Transmisión</label>
                        <input type="text" class="form-control" id="transmision" name="transmision" value="<?php echo htmlspecialchars($vehiculo['transmision']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="n_motor" class="form-label">Número de Motor</label>
                        <input type="text" class="form-control" id="n_motor" name="n_motor" value="<?php echo htmlspecialchars($vehiculo['n_motor']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="n_serie" class="form-label">Número de Serie</label>
                        <input type="text" class="form-control" id="n_serie" name="n_serie" value="<?php echo htmlspecialchars($vehiculo['n_serie']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="placas" class="form-label">Placas</label>
                        <input type="text" class="form-control" id="placas" name="placas" value="<?php echo htmlspecialchars($vehiculo['placas']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad</label>
                        <input type="number" class="form-control" id="capacidad" name="capacidad" value="<?php echo htmlspecialchars($vehiculo['capacidad']); ?>" required>
                    </div>

                    <!-- Campo de estado -->
                    <div class="mb-3">
                        <label for="id_estado" class="form-label">Estado</label>
                        <select class="form-select" name="id_estado" id="id_estado" required>
                            <?php
                            $stmt_estado = $pdo->query("SELECT * FROM estado");
                            while ($estado = $stmt_estado->fetch(PDO::FETCH_ASSOC)) {
                                $selected = ($estado['id_estado'] == $vehiculo['id_estado']) ? 'selected' : '';
                                echo "<option value='{$estado['id_estado']}' $selected>{$estado['estado']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Cargar documentos -->
                    <div class="mb-3">
                        <label for="seguro" class="form-label">Seguro (PDF)</label>
                        <input type="file" class="form-control" name="seguro" id="seguro" accept="application/pdf">
                    </div>
                    <div class="mb-3">
                        <label for="circulacion" class="form-label">Circulación (PDF)</label>
                        <input type="file" class="form-control" name="circulacion" id="circulacion" accept="application/pdf">
                    </div>
                    <div class="mb-3">
    <label for="id_propietario" class="form-label">Propietario</label>
    <select class="form-control" id="id_propietario" name="id_propietario" required>
        <option value="">Seleccione un propietario</option>
        <?php foreach ($propietarios as $propietario): ?>
            <option value="<?php echo $propietario['id_propietario']; ?>" 
                <?php echo ($propietario['id_propietario'] == $vehiculo['id_propietario']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($propietario['nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
                    <!-- Botones -->
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="editar_carro.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
