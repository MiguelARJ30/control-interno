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

$sqlEstado = "SELECT id_estado, estado FROM estado";
$stmtEstado = $pdo->prepare($sqlEstado);
$stmtEstado->execute();
$estados = $stmtEstado->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $nombre = $_POST['Nombre'] ?? '';
    $direccion = $_POST['Direccion'] ?? '';
    $telefono = $_POST['Telefono'] ?? '';
    $fecha_alta = $_POST['Fecha_alta'] ?? '';

    // Asignar automáticamente los valores de id_estado y id_estado_conductor a 1
    $id_estado = 1;  // Valor fijo para id_estado
    $id_estado_conductor = 1;  // Valor fijo para id_estado_conductor

    // Validación de los campos
    if (empty($nombre)) {
        $error = 'El campo Nombre es requerido.';
    } elseif (empty($direccion)) {
        $error = 'El campo Dirección es requerido.';
    } elseif (empty($telefono)) {
        $error = 'El campo Teléfono es requerido.';
    } elseif (empty($fecha_alta)) {
        $error = 'El campo Fecha de Alta es requerido.';
    } elseif (isset($_FILES['Licencia'], $_FILES['credencial'], $_FILES['Comprobante_domicilio'], $_FILES['CURP'], $_FILES['RFC'], $_FILES['Lineamientos'], $_FILES['Contrato'])) {
        // Verificar los archivos
        $documents = ['Licencia', 'credencial', 'Comprobante_domicilio', 'CURP', 'RFC', 'Lineamientos', 'Contrato'];
        foreach ($documents as $document) {
            if ($_FILES[$document]['error'] != UPLOAD_ERR_OK) {
                $error = "El archivo de $document es requerido.";
                break;
            }
        }

        if (empty($error)) {
            // Carpeta donde se guardarán los archivos
            $uploadDir = 'conductores/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Crea el directorio principal si no existe
            }
            
            $conductorDir = $uploadDir . trim($nombre) . '/'; // Elimina los espacios en blanco alrededor del nombre
            if (!file_exists($conductorDir)) {
                mkdir($conductorDir, 0777, true); // Crea el directorio del conductor si no existe
            }
            
            // Ahora procede con el resto de la carga de archivos
            $paths = [];
            foreach ($documents as $document) {
                $fileTmpName = $_FILES[$document]['tmp_name'];
                $fileExt = pathinfo($_FILES[$document]['name'], PATHINFO_EXTENSION);
                $fileName = trim($nombre) . '_' . $document . '.' . $fileExt; // Elimina los espacios del nombre del archivo
                $filePath = $conductorDir . $fileName;
            
                if (!move_uploaded_file($fileTmpName, $filePath)) {
                    $error = "Error al subir el archivo de $document.";
                    break;
                }
                $paths[$document] = $filePath;
            }

            // Si no hay errores, insertar el conductor en la base de datos
            if (empty($error)) {
                $sql = "INSERT INTO conductor (Nombre, Direccion, Telefono, Fecha_alta, Licencia, credencial, Comprobante_domicilio, CURP, RFC, Lineamientos, Contrato, id_estado, id_estado_conductor) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $nombre, $direccion, $telefono, $fecha_alta, 
                    $paths['Licencia'], $paths['credencial'], $paths['Comprobante_domicilio'], 
                    $paths['CURP'], $paths['RFC'], $paths['Lineamientos'], $paths['Contrato'], $id_estado, $id_estado_conductor
                ]);

                $success = 'Conductor registrado exitosamente.';
            }
        }
    } else {
        $error = 'Debe subir todos los documentos requeridos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Conductor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .center-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Menu carro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Bienvenido, <?php echo htmlspecialchars($usuario); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h2>Registro de Conductor</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="registro_conductor.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="Nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="Nombre" name="Nombre" required>
        </div>
        <div class="mb-3">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion" required>
        </div>
        <div class="mb-3">
            <label for="Telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="Telefono" name="Telefono" required>
        </div>
        <div class="mb-3">
            <label for="Fecha_alta" class="form-label">Fecha de Alta</label>
            <input type="date" class="form-control" id="Fecha_alta" name="Fecha_alta" required>
        </div>
        <div class="mb-3">
            <label for="Licencia" class="form-label">Licencia</label>
            <input type="file" class="form-control" id="Licencia" name="Licencia" required>
        </div>
        <div class="mb-3">
            <label for="credencial" class="form-label">Credencial</label>
            <input type="file" class="form-control" id="credencial" name="credencial" required>
        </div>
        <div class="mb-3">
            <label for="Comprobante_domicilio" class="form-label">Comprobante de Domicilio</label>
            <input type="file" class="form-control" id="Comprobante_domicilio" name="Comprobante_domicilio" required>
        </div>
        <div class="mb-3">
            <label for="CURP" class="form-label">CURP</label>
            <input type="file" class="form-control" id="CURP" name="CURP" required>
        </div>
        <div class="mb-3">
            <label for="RFC" class="form-label">RFC</label>
            <input type="file" class="form-control" id="RFC" name="RFC" required>
        </div>
        <div class="mb-3">
            <label for="Lineamientos" class="form-label">Lineamientos</label>
            <input type="file" class="form-control" id="Lineamientos" name="Lineamientos" required>
        </div>
        <div class="mb-3">
            <label for="Contrato" class="form-label">Contrato</label>
            <input type="file" class="form-control" id="Contrato" name="Contrato" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Conductor</button>
    </form>
</div>
</body>
</html>
