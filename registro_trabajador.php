<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
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
    $correo = $_POST['Correo'] ?? '';
    $CURP = $_POST['CURP'] ?? '';
    
    // Asignar automáticamente el valor de id_estado a 1 (puedes modificarlo según tu lógica)
    $id_estado = 1;  // Valor fijo para id_estado

    // Validación de los campos
    if (empty($nombre)) {
        $error = 'El campo Nombre es requerido.';
    } elseif (empty($direccion)) {
        $error = 'El campo Dirección es requerido.';
    } elseif (empty($telefono)) {
        $error = 'El campo Teléfono es requerido.';
    } elseif (empty($fecha_alta)) {
        $error = 'El campo Fecha de Alta es requerido.';
    } elseif (empty($correo)) {
        $error = 'El campo Correo es requerido.';
    } elseif (isset($_FILES['documento_curp'], $_FILES['credencial'], $_FILES['comprobante_domicilio'], $_FILES['RFC'], $_FILES['lineamientos'], $_FILES['contrato'])) {
        // Verificar los archivos
        $documents = ['documento_curp', 'credencial', 'comprobante_domicilio', 'RFC', 'lineamientos', 'contrato'];
        foreach ($documents as $document) {
            if ($_FILES[$document]['error'] != UPLOAD_ERR_OK) {
                $error = "El archivo de $document es requerido.";
                break;
            }
        }

        if (empty($error)) {
            // Carpeta donde se guardarán los archivos
            $uploadDir = 'trabajadores/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Crea el directorio principal si no existe
            }
            
            $trabajadorDir = $uploadDir . trim($nombre) . '/'; // Elimina los espacios en blanco alrededor del nombre
            if (!file_exists($trabajadorDir)) {
                mkdir($trabajadorDir, 0777, true); // Crea el directorio del trabajador si no existe
            }
            
            // Ahora procede con el resto de la carga de archivos
            $paths = [];
            foreach ($documents as $document) {
                $fileTmpName = $_FILES[$document]['tmp_name'];
                $fileExt = pathinfo($_FILES[$document]['name'], PATHINFO_EXTENSION);
                $fileName = trim($nombre) . '_' . $document . '.' . $fileExt; // Elimina los espacios del nombre del archivo
                $filePath = $trabajadorDir . $fileName;
            
                if (!move_uploaded_file($fileTmpName, $filePath)) {
                    $error = "Error al subir el archivo de $document.";
                    break;
                }
                $paths[$document] = $filePath;
            }

            // Si no hay errores, insertar el trabajador en la base de datos
            if (empty($error)) {
                $sql = "INSERT INTO trabajador (nombre, direccion, telefono, fecha_alta, correo, CURP, documento_curp, credencial, comprobante_domicilio, RFC, lineamientos, contrato, id_estado) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $nombre, $direccion, $telefono, $fecha_alta, $correo, $CURP,
                    $paths['documento_curp'], $paths['credencial'], 
                    $paths['comprobante_domicilio'], $paths['RFC'], $paths['lineamientos'], $paths['contrato'], $id_estado
                ]);

                $success = 'Trabajador registrado exitosamente.';
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
    <title>Registrar Trabajador</title>
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
    <h2>Registro de Trabajador</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="registro_trabajador.php" method="POST" enctype="multipart/form-data">
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
            <label for="Correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="Correo" name="Correo" required>
        </div>
        <div class="mb-3">
            <label for="CURP" class="form-label">CURP</label>
            <input type="text" class="form-control" id="CURP" name="CURP" required>
        </div>
        <div class="mb-3">
            <label for="documento_curp" class="form-label">Documento CURP</label>
            <input type="file" class="form-control" id="documento_curp" name="documento_curp" required>
        </div>
        <div class="mb-3">
            <label for="credencial" class="form-label">Credencial</label>
            <input type="file" class="form-control" id="credencial" name="credencial" required>
        </div>
        <div class="mb-3">
            <label for="comprobante_domicilio" class="form-label">Comprobante de Domicilio</label>
            <input type="file" class="form-control" id="comprobante_domicilio" name="comprobante_domicilio" required>
        </div>
        <div class="mb-3">
            <label for="RFC" class="form-label">RFC</label>
            <input type="file" class="form-control" id="RFC" name="RFC" required>
        </div>
        <div class="mb-3">
            <label for="lineamientos" class="form-label">Lineamientos</label>
            <input type="file" class="form-control" id="lineamientos" name="lineamientos" required>
        </div>
        <div class="mb-3">
            <label for="contrato" class="form-label">Contrato</label>
            <input type="file" class="form-control" id="contrato" name="contrato" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Trabajador</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
