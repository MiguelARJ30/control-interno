<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Variable de error
$error = '';

// Consultar los puestos
$sqlPuestos = "SELECT id_puesto, puesto FROM puesto";
$stmtPuestos = $pdo->query($sqlPuestos);
$puestos = $stmtPuestos->fetchAll(PDO::FETCH_ASSOC);

// Consultar los trabajadores
$sqlTrabajadores = "SELECT id_trabajador, nombre FROM trabajador WHERE id_estado = 1;";
$stmtTrabajadores = $pdo->query($sqlTrabajadores);
$trabajadores = $stmtTrabajadores->fetchAll(PDO::FETCH_ASSOC);

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $id_puesto = $_POST['puesto'] ?? '';
    $id_trabajador = $_POST['trabajador'] ?? '';

    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($password) || empty($id_puesto) || empty($id_trabajador)) {
        $error = 'Todos los campos son requeridos.';
    } else {
        // Comprobar si el usuario ya existe
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario]);
        $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userExists) {
            $error = 'El nombre de usuario ya está en uso.';
        } else {
            // Encriptar la contraseña
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (usuario, password, id_puesto, id_trabajador, id_estado) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario, $password_hashed, $id_puesto, $id_trabajador, 1]);

            // Redirigir a una página de éxito o login después de registrar
            header('Location: index.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow-lg" style="width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center">Registro de Usuario</h5>

                <!-- Mostrar mensaje de error si existe -->
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de registro -->
                <form action="registro.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="puesto" class="form-label">Puesto</label>
                        <select class="form-control" id="puesto" name="puesto" required>
                            <option value="">Selecciona un puesto</option>
                            <?php foreach ($puestos as $puesto): ?>
                                <option value="<?= $puesto['id_puesto'] ?>"><?= $puesto['puesto'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="trabajador" class="form-label">Trabajador</label>
                        <select class="form-control" id="trabajador" name="trabajador" required>
                            <option value="">Selecciona un trabajador</option>
                            <?php foreach ($trabajadores as $trabajador): ?>
                                <option value="<?= $trabajador['id_trabajador'] ?>"><?= $trabajador['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
