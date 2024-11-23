<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$usuario = $_SESSION['user'];
include('conexion.php'); // Esto ahora carga la conexión PDO

// Consulta para obtener los datos de la tabla supervision y unir con las tablas asignacion, carro y conductor
$sql = "
    SELECT 
        s.id_supervision,
        s.id_asignacion,
        s.id_inventario,
        s.inventario,
        s.reporte,
        s.fecha,
        c.placas,
        co.nombre
    FROM 
        supervision s
    JOIN 
        asignacion a ON s.id_asignacion = a.id_asignacion
    JOIN 
        carro c ON a.id_carro = c.id_carro
    JOIN 
        conductor co ON a.id_conductor = co.id_conductor
";

try {
    // Usar la conexión PDO para preparar y ejecutar la consulta
    $stmt = $pdo->query($sql);

    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Supervisión</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Supervisión</h1>
        <table class="table table-striped">
            <thead class="table-dark" style="background-color: black; color: violet;">
                <tr>
                    <th>#</th>
                    <th>Placas del Carro</th>
                    <th>Nombre del Conductor</th>
                    <th>Inventario</th>
                    <th>Reporte</th>
                    <th>Fecha</th>
                    <th>Inventario</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar si hay resultados
                if ($result && count($result) > 0) {
                    // Iterar sobre los resultados y mostrarlos en filas de la tabla
                    foreach ($result as $row) {
                        echo "<tr>
                                <td>{$row['id_supervision']}</td>
                                <td>{$row['placas']}</td>
                                <td>{$row['nombre']}</td>
                                <td>
                                    <a href='{$row['inventario']}' target='_blank' class='btn btn-primary'>
                                        Ver Inventario
                                    </a>
                                </td>
                                <td>
                                    <a href='{$row['reporte']}' target='_blank' class='btn btn-primary'>
                                        Ver Reporte
                                    </a>
                                </td>
                                <td>{$row['fecha']}</td>
                                <td>
                                    <a href='supervision_editado.php?id_inventario={$row['id_inventario']}' class='btn btn-primary'>
                                        Editar
                                    </a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Enlace a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
