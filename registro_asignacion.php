<?php
session_start();

// Redirigir si no hay usuario en sesión
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Conectar a la base de datos
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos seleccionados del formulario
    $id_carro = $_POST['placas'];
    $id_conductor = $_POST['conductor'];
    $id_estado = 1; // Puedes ajustar este valor según sea necesario (1 = asignado)

    try {
        // Iniciar una transacción
        $pdo->beginTransaction();

        // Insertar la asignación en la base de datos
        $sql = "INSERT INTO asignacion (id_carro, id_conductor, id_estado) VALUES (:id_carro, :id_conductor, :id_estado)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_carro' => $id_carro, 'id_conductor' => $id_conductor, 'id_estado' => $id_estado]);

        // Actualizar el estado del carro
        $sqlCarro = "UPDATE carro SET id_estado_carro = 2 WHERE id_carro = :id_carro";
        $stmtCarro = $pdo->prepare($sqlCarro);
        $stmtCarro->execute(['id_carro' => $id_carro]);

        // Actualizar el estado del conductor
        $sqlConductor = "UPDATE conductor SET id_estado_conductor = 2 WHERE id_conductor = :id_conductor";
        $stmtConductor = $pdo->prepare($sqlConductor);
        $stmtConductor->execute(['id_conductor' => $id_conductor]);

        // Confirmar la transacción
        $pdo->commit();

        // Mensaje de éxito
        $_SESSION['mensaje'] = "Asignación realizada con éxito. El estado del vehículo y del conductor se ha actualizado.";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $pdo->rollBack();
        $_SESSION['mensaje'] = "Hubo un error al realizar la asignación: " . $e->getMessage();
    }

    // Redirigir para mostrar el mensaje
    header('Location: registro_asignacion.php');
    exit();
}

// Consultar vehículos disponibles (id_estado = 1)
$sqlCarros = "SELECT id_carro, placas FROM carro WHERE id_estado_carro = 1 AND id_estado = 1";
$stmtCarros = $pdo->prepare($sqlCarros);
$stmtCarros->execute();
$carros = $stmtCarros->fetchAll(PDO::FETCH_ASSOC);

// Consultar conductores disponibles (id_estado = 1)
$sqlConductores = "SELECT id_conductor, nombre FROM conductor WHERE id_estado_conductor = 1 AND id_estado = 1";
$stmtConductores = $pdo->prepare($sqlConductores);
$stmtConductores->execute();
$conductores = $stmtConductores->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Vehículo y Conductor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h3 class="card-title text-center">Asignar Vehículo y Conductor</h3>

                <!-- Mostrar mensaje de éxito o error -->
                <?php if (isset($_SESSION['mensaje'])): ?>
                    <div class="alert alert-info">
                        <?php
                        echo $_SESSION['mensaje'];
                        unset($_SESSION['mensaje']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="registro_asignacion.php" method="POST">
                    <!-- Selección de Placa de Vehículo -->
                    <div class="mb-3">
                        <label for="placas" class="form-label">Selecciona una Placa de Vehículo</label>
                        <select class="form-select" id="placas" name="placas" required>
                            <option value="" disabled selected>Selecciona una placa</option>
                            <?php foreach ($carros as $carro): ?>
                                <option value="<?php echo htmlspecialchars($carro['id_carro']); ?>">
                                    <?php echo htmlspecialchars($carro['placas']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Selección de Nombre del Conductor -->
                    <div class="mb-3">
                        <label for="conductor" class="form-label">Selecciona un Conductor</label>
                        <select class="form-select" id="conductor" name="conductor" required>
                            <option value="" disabled selected>Selecciona un conductor</option>
                            <?php foreach ($conductores as $conductor): ?>
                                <option value="<?php echo htmlspecialchars($conductor['id_conductor']); ?>">
                                    <?php echo htmlspecialchars($conductor['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Asignar Vehículo y Conductor</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
