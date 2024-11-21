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
$id_trabajador = $_GET['id'] ?? null;
$datosTrabajador = [];

// Cargar datos del trabajador si existe un id_trabajador
if ($id_trabajador) {
    $sqlTrabajador = "SELECT * FROM trabajador WHERE id_trabajador = ?";
    $stmtTrabajador = $pdo->prepare($sqlTrabajador);
    $stmtTrabajador->execute([$id_trabajador]);
    $datosTrabajador = $stmtTrabajador->fetch(PDO::FETCH_ASSOC);
}

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
    $curp = $_POST['CURP'] ?? '';
    $id_estado = $_POST['id_estado'] ?? ''; // Este campo lo mantenemos intacto

    // Validación de los campos
    if (empty($nombre)) {
        $error = 'El campo Nombre es requerido.';
    } elseif (empty($direccion)) {
        $error = 'El campo Dirección es requerido.';
    } elseif (empty($telefono)) {
        $error = 'El campo Teléfono es requerido.';
    } elseif (empty($fecha_alta)) {
        $error = 'El campo Fecha de Alta es requerido.';
    } elseif (empty($id_estado)) {
        $error = 'El campo Estado es requerido.';
    } else {
        // Carpeta donde se guardarán los archivos
        $uploadDir = 'trabajadores/' . trim($nombre) . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Verificar cada documento y, si hay uno nuevo, reemplazarlo
        $documents = ['documento_curp', 'credencial', 'comprobante_domicilio', 'RFC', 'lineamientos', 'contrato'];
        $paths = [];

        foreach ($documents as $document) {
            if (!empty($_FILES[$document]['tmp_name'])) {
                // Si hay un nuevo archivo, subirlo
                $fileTmpName = $_FILES[$document]['tmp_name'];
                $fileExt = pathinfo($_FILES[$document]['name'], PATHINFO_EXTENSION);
                $fileName = trim($nombre) . '_' . $document . '.' . $fileExt;
                $filePath = $uploadDir . $fileName;

                if (!move_uploaded_file($fileTmpName, $filePath)) {
                    $error = "Error al subir el archivo de $document.";
                    break;
                }
                $paths[$document] = $filePath;
            } else {
                // Si no hay un nuevo archivo, mantener el archivo actual
                $paths[$document] = $datosTrabajador[$document] ?? null;
            }
        }

        if (empty($error)) {
            if ($id_trabajador) {
                // Actualizar el trabajador si ya existe
                $sql = "UPDATE trabajador SET nombre=?, direccion=?, telefono=?, fecha_alta=?, correo=?, CURP=?, documento_curp=?, credencial=?, comprobante_domicilio=?, RFC=?, lineamientos=?, contrato=?, id_estado=? WHERE id_trabajador=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $nombre, $direccion, $telefono, $fecha_alta, $correo, $curp,
                    $paths['documento_curp'], $paths['credencial'], $paths['comprobante_domicilio'],
                    $paths['RFC'], $paths['lineamientos'], $paths['contrato'],
                    $id_estado, $id_trabajador
                ]);
                $success = 'Trabajador actualizado exitosamente.';
            } else {
                // Insertar un nuevo trabajador si no existe
                $sql = "INSERT INTO trabajador (nombre, direccion, telefono, fecha_alta, correo, CURP, documento_curp, credencial, comprobante_domicilio, RFC, lineamientos, contrato, id_estado)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $nombre, $direccion, $telefono, $fecha_alta, $correo, $curp,
                    $paths['documento_curp'], $paths['credencial'], $paths['comprobante_domicilio'],
                    $paths['RFC'], $paths['lineamientos'], $paths['contrato'],
                    $id_estado
                ]);
                $success = 'Trabajador registrado exitosamente.';
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
    <title>Registrar Trabajador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Menu Trabajadores</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
    <h2><?php echo $id_trabajador ? 'Actualizar Trabajador' : 'Registro de Trabajador'; ?></h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="Nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?php echo $datosTrabajador['nombre'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion" value="<?php echo $datosTrabajador['direccion'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="Telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="Telefono" name="Telefono" value="<?php echo $datosTrabajador['telefono'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="Fecha_alta" class="form-label">Fecha de Alta</label>
            <input type="date" class="form-control" id="Fecha_alta" name="Fecha_alta" value="<?php echo $datosTrabajador['fecha_alta'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="Correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="Correo" name="Correo" value="<?php echo $datosTrabajador['correo'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="CURP" class="form-label">CURP</label>
            <input type="text" class="form-control" id="CURP" name="CURP" value="<?php echo $datosTrabajador['CURP'] ?? ''; ?>" required>
        </div>

        <!-- No tocar el estado -->
        <input type="hidden" name="id_estado" value="<?php echo $datosTrabajador['id_estado'] ?? ''; ?>">

        <div class="mb-3">
            <label class="form-label">Documentos</label>
            <?php
            $documentLabels = ['documento_curp' => 'CURP', 'credencial' => 'Credencial', 'comprobante_domicilio' => 'Comprobante de Domicilio', 'RFC' => 'RFC', 'lineamientos' => 'Lineamientos', 'contrato' => 'Contrato'];
            foreach ($documentLabels as $field => $label):
                $currentFile = $datosTrabajador[$field] ?? '';
            ?>
                <div class="mb-2">
                    <label for="<?php echo $field; ?>" class="form-label"><?php echo $label; ?></label>
                    <input type="file" class="form-control" name="<?php echo $field; ?>">
                    <?php if ($currentFile): ?>
                        <p><a href="<?php echo $currentFile; ?>" target="_blank">Ver documento actual</a></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $id_trabajador ? 'Actualizar' : 'Registrar'; ?></button>
    </form>
</div>
</body>
</html>
