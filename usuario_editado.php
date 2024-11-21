<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener el id_usuario de la URL
$id_usuario = isset($_GET['id']) ? $_GET['id'] : 0;

// Consultar los datos del usuario con el id_usuario
$sqlUsuario = "SELECT 
        usuarios.id_usuario,
        usuarios.usuario,
        usuarios.password,
        usuarios.id_puesto
    FROM 
        usuarios
    WHERE 
        usuarios.id_usuario = ?";
$stmtUsuario = $pdo->prepare($sqlUsuario);
$stmtUsuario->execute([$id_usuario]);
$usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra el usuario, redirigir a la página de usuarios
if (!$usuario) {
    header("Location: usuarios.php?mensaje=usuario_no_encontrado");
    exit();
}

// Obtener los puestos para el select
$sql_puestos = "SELECT * FROM puesto";
$stmt_puestos = $pdo->query($sql_puestos);
$puestos = $stmt_puestos->fetchAll(PDO::FETCH_ASSOC);

// Variables para los campos del formulario
$usuario_nombre = $usuario['usuario'];
$password = $usuario['password'];  // Se mantiene en base64
$puesto = $usuario['id_puesto'];

// Variable de error
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $usuario_nombre = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $puesto = $_POST['puesto'] ?? '';

    // Validar que los campos no estén vacíos
    if (empty($usuario_nombre) || empty($password) || empty($puesto)) {
        $error = 'Todos los campos son requeridos.';
    } else {
        // Codificar la contraseña con base64
        $password_encoded = base64_encode($password);

        // Actualizar el usuario en la base de datos
        $sqlUpdate = "UPDATE usuarios SET usuario = ?, password = ?, id_puesto = ? WHERE id_usuario = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$usuario_nombre, $password_encoded, $puesto, $id_usuario]);

        // Redirigir a la página de usuarios con mensaje de éxito
        header('Location: menu_usuario.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3 class="text-center">Editar Usuario</h3>

        <!-- Mostrar mensaje de error si existe -->
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="usuario_editado.php?id=<?= $id_usuario ?>" method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario_nombre) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <!-- Aquí se muestra la contraseña codificada en base64 -->
                <input type="text" class="form-control" id="password" name="password" value="<?= htmlspecialchars($password) ?>" required>
            </div>
            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <select class="form-control" id="puesto" name="puesto" required>
                    <?php foreach ($puestos as $puesto_item): ?>
                        <option value="<?= $puesto_item['id_puesto'] ?>" <?= $puesto_item['id_puesto'] == $puesto ? 'selected' : '' ?>>
                            <?= $puesto_item['puesto'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Actualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
