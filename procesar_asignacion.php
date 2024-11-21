<?php
require 'conexion.php';

if (!isset($_POST['asignacion']) || empty($_POST['asignacion'])) {
    die("Falta seleccionar una asignación.");
}

if (!isset($_POST['id_inventario']) || empty($_POST['id_inventario'])) {
    die("Falta el ID de inventario.");
}

if (!isset($_FILES['inventario']) || $_FILES['inventario']['error'] !== UPLOAD_ERR_OK) {
    die("Falta subir el archivo de inventario.");
}

if (!isset($_FILES['reporte']) || $_FILES['reporte']['error'] !== UPLOAD_ERR_OK) {
    die("Falta subir el archivo de reporte.");
}

// Guardar los datos en variables
$id_asignacion = htmlspecialchars($_POST['asignacion']);
$id_inventario = htmlspecialchars($_POST['id_inventario']);
$fecha = date("Y-m-d_H-i-s"); // Formato de fecha para el nombre del archivo

// Validación de extensiones de archivos para evitar archivos maliciosos
$allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png'];
$inventario_extension = strtolower(pathinfo($_FILES['inventario']['name'], PATHINFO_EXTENSION));
$reporte_extension = strtolower(pathinfo($_FILES['reporte']['name'], PATHINFO_EXTENSION));

if (!in_array($inventario_extension, $allowed_extensions)) {
    die("Formato de archivo de inventario no permitido.");
}
if (!in_array($reporte_extension, $allowed_extensions)) {
    die("Formato de archivo de reporte no permitido.");
}

// Crear nombres únicos para los archivos
$inventario_filename = "asignacion_{$id_asignacion}_inventario_{$fecha}." . $inventario_extension;
$reporte_filename = "asignacion_{$id_asignacion}_reporte_{$fecha}." . $reporte_extension;

// Ruta para guardar los archivos en la carpeta 'uploads'
$inventario_dir = 'uploads/' . $inventario_filename;
$reporte_dir = 'uploads/' . $reporte_filename;

// Mover los archivos a la carpeta de destino con el nuevo nombre
if (!move_uploaded_file($_FILES['inventario']['tmp_name'], $inventario_dir)) {
    die("Error al subir el archivo de inventario.");
}

if (!move_uploaded_file($_FILES['reporte']['tmp_name'], $reporte_dir)) {
    die("Error al subir el archivo de reporte.");
}

// Insertar en la base de datos
$sql = "INSERT INTO supervision (id_asignacion, id_inventario, inventario, reporte, fecha) 
        VALUES (:id_asignacion, :id_inventario, :inventario, :reporte, :fecha)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_asignacion', $id_asignacion);
$stmt->bindParam(':id_inventario', $id_inventario);
$stmt->bindParam(':inventario', $inventario_dir);
$stmt->bindParam(':reporte', $reporte_dir);
$stmt->bindParam(':fecha', $fecha);

if ($stmt->execute()) {
    echo "Datos registrados correctamente.";
    // Redirigir después de un tiempo de espera
    header("Refresh: 2; URL=supervision.php?id_inventario=$id_inventario");
} else {
    echo "Error al registrar los datos.";
}
?>
