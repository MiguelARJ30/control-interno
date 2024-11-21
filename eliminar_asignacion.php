<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Verificar si se envían los IDs
if (!isset($_POST['id_asignacion']) || !isset($_POST['id_carro']) || !isset($_POST['id_conductor'])) {
    header('Location: listado_asignaciones.php?error=1');
    exit;
}

$id_asignacion = $_POST['id_asignacion'];
$id_carro = $_POST['id_carro'];
$id_conductor = $_POST['id_conductor'];

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

try {
    // Iniciar la transacción
    $pdo->beginTransaction();

    // Actualizar estado en la tabla de asignaciones
    $sql = "UPDATE asignacion SET id_estado = 2 WHERE id_asignacion = :id_asignacion";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_asignacion', $id_asignacion, PDO::PARAM_INT);
    $stmt->execute();

    // Actualizar estado en la tabla de carros
    $sql = "UPDATE carro SET id_estado_carro = 1 WHERE id_carro = :id_carro";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_carro', $id_carro, PDO::PARAM_INT);
    $stmt->execute();

    // Actualizar estado en la tabla de conductores
    $sql = "UPDATE conductor SET id_estado_conductor = 1 WHERE id_conductor = :id_conductor";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_conductor', $id_conductor, PDO::PARAM_INT);
    $stmt->execute();

    // Confirmar los cambios
    $pdo->commit();

    header('Location: asignacion_eliminado.php?success=1');
} catch (Exception $e) {
    $pdo->rollBack();
    header('Location: asignacion_eliminado.php?error=1');
    exit;
}
?>
