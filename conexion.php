<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // Dirección de tu servidor MySQL
$dbname = 'sistema_trasla'; // Nombre de la base de datos
$username = 'root'; // Usuario de la base de datos (puede ser diferente según tu configuración)
$password = ''; // Contraseña de la base de datos (cambia según tu configuración)

// Intentar conectar a la base de datos
try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Configurar el modo de error a excepción para manejar errores de manera adecuada
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si la conexión es exitosa, podemos continuar con las consultas
    //echo "Conexión exitosa";
} catch (PDOException $e) {
    // Si ocurre un error, lo capturamos y mostramos el mensaje
    echo "Error de conexión: " . $e->getMessage();
    exit(); // Detenemos el script si no podemos conectarnos a la base de datos
}
?>
