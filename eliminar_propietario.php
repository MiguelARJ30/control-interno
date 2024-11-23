<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_propietario = $_POST['id_propietario'];

    try {
        // Actualizar el id_estado del propietario a 2 (eliminado)
        $sql = "UPDATE propietario SET id_estado = 2 WHERE id_propietario = :id_propietario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_propietario', $id_propietario, PDO::PARAM_INT);
        $stmt->execute();

        // Redirigir con el mensaje de éxito
        header('Location: propietario_eliminado.php?status=success');
        exit();
    } catch (PDOException $e) {
        // Redirigir con el mensaje de error
        header('Location: propietario_eliminado.php?status=error');
        exit();
    }
}
