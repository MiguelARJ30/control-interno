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
        // Verificar si hay carros con id_estado_carro = 2 asociados al propietario
        $sql_check = "SELECT COUNT(*) AS total FROM carro WHERE id_propietario = :id_propietario AND id_estado_carro = 2";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':id_propietario', $id_propietario, PDO::PARAM_INT);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($result['total'] > 0) {
            // Si existe al menos un carro con id_estado_carro = 2, redirigir con mensaje de error
            header('Location: propietario_eliminado.php?status=carro_asignado');
            exit();
        }

        // Si no hay carros asignados, proceder con la actualización del estado
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
