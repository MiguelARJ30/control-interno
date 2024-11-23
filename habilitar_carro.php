<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: index.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user'];

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si se ha pasado el ID del vehículo
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si no se pasa el ID, redirigir a la lista de vehículos
    header('Location: listado_carros.php');
    exit;
}

$id_carro = $_GET['id'];

// Actualizar el estado del vehículo a 'Eliminado' (id_status = 2)
$sql = "UPDATE carro SET id_estado = 1 WHERE id_carro = :id_carro";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_carro', $id_carro);

// Ejecutar la consulta para actualizar el estado
if ($stmt->execute()) {
    // Si se actualiza correctamente, redirigir a la lista de vehículos
    header('Location: activar_carro.php');
    exit;
} else {
    // Si hubo un error, mostrar mensaje de error (opcional)
    echo "Error al actualizar el estado del vehículo.";
}
?>
