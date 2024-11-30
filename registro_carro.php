<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$usuario = $_SESSION['user'];
include('conexion.php');

$error = '';
$success = '';

// Obtener los estados
$sqlEstado = "SELECT id_estado, estado FROM estado";
$stmtEstado = $pdo->prepare($sqlEstado);
$stmtEstado->execute();
$estados = $stmtEstado->fetchAll(PDO::FETCH_ASSOC);

// Obtener los propietarios
$sqlPropietario = "SELECT id_propietario, nombre FROM propietario WHERE id_estado = 1;";
$stmtPropietario = $pdo->prepare($sqlPropietario);
$stmtPropietario->execute();
$propietarios = $stmtPropietario->fetchAll(PDO::FETCH_ASSOC);

// Obtener los tipos de vehículo
$sqlTipo = "SELECT id_tipo, tipo_nombre FROM tipo";
$stmtTipo = $pdo->prepare($sqlTipo);
$stmtTipo->execute();
$tipos = $stmtTipo->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tipos = $_POST['id_tipos'] ?? '';
    $tipo = $_POST['tipo'] ??'';
    $modelo = $_POST['modelo'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $color = $_POST['color'] ?? '';
    $transmision = $_POST['transmision'] ?? '';
    $n_motor = $_POST['n_motor'] ?? '';
    $n_serie = $_POST['n_serie'] ?? '';
    $placas = $_POST['placas'] ?? '';
    $capacidad = $_POST['capacidad'] ?? '';
    $id_propietario = $_POST['id_propietario'] ?? '';

    $id_estado = 1; // Valor fijo para id_estado
    $id_estado_carro = 1; // Valor fijo para id_estado_carro

    if (empty($id_tipos) || empty($tipo) || empty($modelo) || empty($marca) || empty($color) || empty($transmision) || empty($n_motor) || empty($n_serie) || empty($placas) || empty($capacidad) || empty($id_propietario)) {
        $error = 'Todos los campos son requeridos.';
    } else {
        $sqlCheck = "SELECT COUNT(*) FROM carro WHERE placas = ? OR n_serie = ? OR n_motor = ?";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([$placas, $n_serie, $n_motor]);
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            $error = 'Error: Ya existe un vehículo con las mismas placas, número de serie o número de motor.';
        } else {
            if (isset($_FILES['seguro']) && isset($_FILES['circulacion'])) {
                $uploadDir = 'carro/';
                $conductorDir = $uploadDir . $placas . '/';
                if (!file_exists($conductorDir)) {
                    mkdir($conductorDir, 0777, true);
                }

                $seguroFile = $_FILES['seguro'];
                $circulacionFile = $_FILES['circulacion'];

                if ($seguroFile['error'] == UPLOAD_ERR_OK) {
                    $seguroTmpName = $seguroFile['tmp_name'];
                    $seguroExt = pathinfo($seguroFile['name'], PATHINFO_EXTENSION);
                    $seguroName = $placas . '_seguro.' . $seguroExt;
                    $seguroPath = $conductorDir . $seguroName;

                    if (!move_uploaded_file($seguroTmpName, $seguroPath)) {
                        $error = 'Error al subir el archivo de seguro.';
                    }
                } else {
                    $error = 'Error en el archivo de seguro.';
                }

                if ($circulacionFile['error'] == UPLOAD_ERR_OK) {
                    $circulacionTmpName = $circulacionFile['tmp_name'];
                    $circulacionExt = pathinfo($circulacionFile['name'], PATHINFO_EXTENSION);
                    $circulacionName = $placas . '_circulacion.' . $circulacionExt;
                    $circulacionPath = $conductorDir . $circulacionName;

                    if (!move_uploaded_file($circulacionTmpName, $circulacionPath)) {
                        $error = 'Error al subir el archivo de circulación.';
                    }
                } else {
                    $error = 'Error en el archivo de circulación.';
                }

                if (empty($error)) {
                    $sql = "INSERT INTO carro (id_tipos, tipo,  modelo, marca, color, transmision, n_motor, n_serie, placas, capacidad, seguro, circulacion, id_estado, id_estado_carro, id_propietario) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        $id_tipos, $tipo,  $modelo, $marca, $color, $transmision, $n_motor, $n_serie, $placas,
                        $capacidad, $seguroPath, $circulacionPath, $id_estado, $id_estado_carro, $id_propietario
                    ]);

                    $success = 'Vehículo registrado exitosamente.';
                }
            } else {
                $error = 'Debe subir los documentos de seguro y circulación.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .center-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }
        .btn-fixed {
            position: fixed;
            bottom: 40px;  /* Distancia desde el borde inferior */
            right: 40px;   /* Distancia desde el borde derecho */
            z-index: 9999; /* Para que quede encima de otros elementos */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-light" style="background-color: #472681;">
        <div class="container-fluid" style="display: flex; align-items: center; justify-content: center;">
            <img src="imagenes/trasla_2.png" alt="" width="160px" height="50px"></a>
        </div>
    </nav>
<div class="container mt-5">
    <div class="card shadow-lg" style="border: 2px solid #472681; border-radius: 50px; padding: 1rem;">
        <div class="card-body">
            <h5 class="card-title" style="color: #472681; padding: 1rem;">Registro de Vehículo</h5>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form action="registro_carro.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3" style="display: flex; flex-direction: column;">
                    <div class="columna1">
                    <label for="id_tipos" class="form-label" style="color: #472681;">Tipo de Vehículo</label>
                    <select class="form-control" id="id_tipos" name="id_tipos" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                        <option value="">Seleccione un tipo</option>
                        <?php foreach ($tipos as $tipo): ?>
                            <option value="<?php echo $tipo['id_tipo']; ?>"><?php echo $tipo['tipo_nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                <div class="mb-3">
                    <label for="tipo" class="form-label" style="color: #472681;">Tipo</label>
                    <input type="text" class="form-control" id="tipo" name="tipo" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" name="color" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="transmision" class="form-label">Transmisión</label>
                    <input type="text" class="form-control" id="transmision" name="transmision" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="n_motor" class="form-label">Número de Motor</label>
                    <input type="text" class="form-control" id="n_motor" name="n_motor" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                </div>
                <div class="mb-3">
                    <label for="n_serie" class="form-label">Número de Serie</label>
                    <input type="text" class="form-control" id="n_serie" name="n_serie" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="placas" class="form-label">Placas</label>
                    <input type="text" class="form-control" id="placas" name="placas" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="capacidad" class="form-label">Capacidad</label>
                    <input type="text" class="form-control" id="capacidad" name="capacidad" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="seguro" class="form-label">Seguro (PDF)</label>
                    <input type="file" class="form-control" id="seguro" name="seguro" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="circulacion" class="form-label">Tarjeta de Circulación (PDF)</label>
                    <input type="file" class="form-control" id="circulacion" name="circulacion" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                </div>
                <div class="mb-3">
                    <label for="id_propietario" class="form-label">Propietario</label>
                    <select class="form-control" id="id_propietario" name="id_propietario" style="border: 2px solid #472681; border-radius: 50px; width: 40%;" required>
                        <option value="">Seleccione un propietario</option>
                        <?php foreach ($propietarios as $propietario): ?>
                            <option value="<?php echo $propietario['id_propietario']; ?>"><?php echo $propietario['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Registrar Vehículo</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
