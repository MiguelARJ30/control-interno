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
$id_conductor = $_GET['id'] ?? null;
$datosConductor = [];

// Cargar datos del conductor si existe un id_conductor
if ($id_conductor) {
    $sqlConductor = "SELECT * FROM conductor WHERE id_conductor = ?";
    $stmtConductor = $pdo->prepare($sqlConductor);
    $stmtConductor->execute([$id_conductor]);
    $datosConductor = $stmtConductor->fetch(PDO::FETCH_ASSOC);
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
    $id_estado = $_POST['id_estado'] ?? '';

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
        $uploadDir = 'conductores/' . trim($nombre) . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Verificar cada documento y, si hay uno nuevo, reemplazarlo
        $documents = ['Licencia', 'credencial', 'Comprobante_domicilio', 'CURP', 'RFC', 'Lineamientos', 'Contrato'];
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
                $paths[$document] = $datosConductor[$document] ?? null;
            }
        }

        if (empty($error)) {
            if ($id_conductor) {
                // Actualizar el conductor si ya existe
                $sql = "UPDATE conductor SET Nombre=?, Direccion=?, Telefono=?, Fecha_alta=?, Licencia=?, credencial=?, Comprobante_domicilio=?, CURP=?, RFC=?, Lineamientos=?, Contrato=?, id_estado=? WHERE id_conductor=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $nombre, $direccion, $telefono, $fecha_alta,
                    $paths['Licencia'], $paths['credencial'], $paths['Comprobante_domicilio'],
                    $paths['CURP'], $paths['RFC'], $paths['Lineamientos'], $paths['Contrato'],
                    $id_estado, $id_conductor
                ]);
                $success = 'Conductor actualizado exitosamente.';
            } else {
                // Insertar un nuevo conductor si no existe
                $sql = "INSERT INTO conductor (Nombre, Direccion, Telefono, Fecha_alta, Licencia, credencial, Comprobante_domicilio, CURP, RFC, Lineamientos, Contrato, id_estado) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $nombre, $direccion, $telefono, $fecha_alta,
                    $paths['Licencia'], $paths['credencial'], $paths['Comprobante_domicilio'],
                    $paths['CURP'], $paths['RFC'], $paths['Lineamientos'], $paths['Contrato'],
                    $id_estado
                ]);
                $success = 'Conductor registrado exitosamente.';
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
    <title>Registrar Conductor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Menu carro</a>
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
    <h2><?php echo $id_conductor ? 'Actualizar Conductor' : 'Registro de Conductor'; ?></h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="Nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?php echo $datosConductor['Nombre'] ?? ''; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion" value="<?php echo $datosConductor['Direccion'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="Telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="Telefono" name="Telefono" value="<?php echo $datosConductor['Telefono'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="Fecha_alta" class="form-label">Fecha de Alta</label>
            <input type="date" class="form-control" id="Fecha_alta" name="Fecha_alta" value="<?php echo $datosConductor['Fecha_alta'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="id_estado" class="form-label">Estado</label>
            <select class="form-select" id="id_estado" name="id_estado" required>
                <option value="" disabled selected>Selecciona un estado</option>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?php echo $estado['id_estado']; ?>" <?php echo ($estado['id_estado'] == $datosConductor['id_estado']) ? 'selected' : ''; ?>>
                        <?php echo $estado['estado']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Licencia -->
<div class="mb-3">
    <label for="Licencia" class="form-label">Licencia</label>
    <?php if (!empty($datosConductor['Licencia'])): ?>
        <p>Archivo actual: <a href="<?php echo $datosConductor['Licencia']; ?>" target="_blank">Ver licencia</a></p>
    <?php endif; ?>
    <input type="file" class="form-control" id="Licencia" name="Licencia" <?php echo $id_conductor ? '' : 'required'; ?>>
</div>

<!-- Credencial -->
<div class="mb-3">
    <label for="credencial" class="form-label">Credencial</label>
    <?php if (!empty($datosConductor['credencial'])): ?>
        <p>Archivo actual: <a href="<?php echo $datosConductor['credencial']; ?>" target="_blank">Ver credencial</a></p>
    <?php endif; ?>
    <input type="file" class="form-control" id="credencial" name="credencial" <?php echo $id_conductor ? '' : 'required'; ?>>
</div>

<!-- Comprobante de Domicilio -->
<div class="mb-3">
    <label for="Comprobante_domicilio" class="form-label">Comprobante de Domicilio</label>
    <?php if (!empty($datosConductor['Comprobante_domicilio'])): ?>
        <p>Archivo actual: <a href="<?php echo $datosConductor['Comprobante_domicilio']; ?>" target="_blank">Ver comprobante</a></p>
    <?php endif; ?>
    <input type="file" class="form-control" id="Comprobante_domicilio" name="Comprobante_domicilio" <?php echo $id_conductor ? '' : 'required'; ?>>
</div>

<!-- CURP -->
<div class="mb-3">
    <label for="CURP" class="form-label">CURP</label>
    <?php if (!empty($datosConductor['CURP'])): ?>
        <p>Archivo actual: <a href="<?php echo $datosConductor['CURP']; ?>" target="_blank">Ver CURP</a></p>
    <?php endif; ?>
    <input type="file" class="form-control" id="CURP" name="CURP" <?php echo $id_conductor ? '' : 'required'; ?>>
</div>

<!-- RFC -->
<div class="mb-3">
    <label for="RFC" class="form-label">RFC</label>
    <?php if (!empty($datosConductor['RFC'])): ?>
        <p>Archivo actual: <a href="<?php echo $datosConductor['RFC']; ?>" target="_blank">Ver RFC</a></p>
    <?php endif; ?>
    <input type="file" class="form-control" id="RFC" name="RFC" <?php echo $id_conductor ? '' : 'required'; ?>>
</div>

<!-- Lineamientos -->
<div class="mb-3">
    <label for="Lineamientos" class="form-label">Lineamientos</label>
    <?php if (!empty($datosConductor['Lineamientos'])): ?>
        <p>Archivo actual: <a href="<?php echo $datosConductor['Lineamientos']; ?>" target="_blank">Ver lineamientos</a></p>
    <?php endif; ?>
    <input type="file" class="form-control" id="Lineamientos" name="Lineamientos" <?php echo $id_conductor ? '' : 'required'; ?>>
</div>

<!-- Contrato -->
<div class="mb-3">
    <label for="Contrato" class="form-label">Contrato</label>
    <?php if (!empty($datosConductor['Contrato'])): ?>
        <p>Archivo actual: <a href="<?php echo $datosConductor['Contrato']; ?>" target="_blank">Ver contrato</a></p>
    <?php endif; ?>
    <input type="file" class="form-control" id="Contrato" name="Contrato" <?php echo $id_conductor ? '' : 'required'; ?>>
</div>
<button type="submit" class="btn btn-primary"><?php echo $id_conductor ? 'Actualizar Conductor' : 'Registrar Conductor'; ?></button>
    </form>
</div>
</body>
</html>