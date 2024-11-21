<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user'];

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si se ha pasado el ID del vehículo
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si no se pasa el ID, redirigir a la lista de vehículos
    header('Location: ver_trabajador.php');
    exit;
}

$id_trabajador = $_GET['id'];

// Actualizar el estado del vehículo a 'Eliminado' (id_status = 2)
$sql = "UPDATE trabajador SET id_estado = 2 WHERE id_trabajador = :id_trabajador";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_trabajador', $id_trabajador);

// Ejecutar la consulta para actualizar el estado
if ($stmt->execute()) {
    // Si se actualiza correctamente, redirigir a la lista de vehículos
    header('Location: trabajador_eliminado.php');
    exit;
} else {
    // Si hubo un error, mostrar mensaje de error (opcional)
    echo "Error al actualizar el estado del vehículo.";
}
?>