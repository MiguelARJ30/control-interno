<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$usuario = $_SESSION['user'];
include('conexion.php');

$error = '';
$propietarios = [];

try {
    $sql = "SELECT propietario.id_propietario, propietario.nombre, estado.estado 
    FROM propietario 
    JOIN estado ON propietario.id_estado = estado.id_estado
    WHERE propietario.id_estado = 1"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $propietarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Error al obtener los propietarios: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Propietarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        <div class="card shadow-lg" style="border: 2px solid #472681; border-radius: 50px;">
            <div class="card-body">
                <h5 class="card-title" style="color: #472681;">Lista de Propietarios</h5>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if (count($propietarios) > 0): ?>
                    <table class="table table-striped mt-3" style="text-align: center;">
                        <thead class="table" style="background-color: #472681; color: white;">
                            <tr>
                                <th>ID Propietario</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($propietarios as $propietario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($propietario['id_propietario']); ?></td>
                                    <td><?php echo htmlspecialchars($propietario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($propietario['estado']); ?></td>
                                    <td>
                                        <a href="propietario_editado.php?id=<?php echo $propietario['id_propietario']; ?>" class="btn btn-primary btn-sm" style="border-radius: 50px; padding:  0.2rem 1rem  0.2rem 1rem;">Editar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">No se encontraron propietarios registrados.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <a class="btn btn-fixed" style="border-radius: 60%; borde: none;" href="menu_propietario.php">
        <img src="imagenes/atras.png" style="width: 85px;">
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
