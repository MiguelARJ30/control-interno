<?php

session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: index.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user']; // Obtener el nombre de usuario desde la sesión
// Incluir el archivo de conexión
include('conexion.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los valores seleccionados de los radio buttons
    $motor = isset($_POST['motor']) ? $_POST['motor'] : null;
    $transmision = isset($_POST['transmision']) ? $_POST['transmision'] : null;
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
    $frenos = isset($_POST['frenos']) ? $_POST['frenos'] : null;
    $electrico = isset($_POST['electrico']) ? $_POST['electrico'] : null;
    $faros = isset($_POST['faros']) ? $_POST['faros'] : null;
    $calaveras = isset($_POST['calaveras']) ? $_POST['calaveras'] : null;
    $direccionales = isset($_POST['direccionales']) ? $_POST['direccionales'] : null;
    $intermitentes = isset($_POST['intermitentes']) ? $_POST['intermitentes'] : null;
    $radio = isset($_POST['radio']) ? $_POST['radio'] : null;
    $reloj = isset($_POST['reloj']) ? $_POST['reloj'] : null;
    $limpiadores = isset($_POST['limpiadores']) ? $_POST['limpiadores'] : null;
    $antena = isset($_POST['antena']) ? $_POST['antena'] : null;
    $tapetes = isset($_POST['tapetes']) ? $_POST['tapetes'] : null;
    $llanta_refaccion = isset($_POST['llanta_refaccion']) ? $_POST['llanta_refaccion'] : null;
    $llantas = isset($_POST['llantas']) ? $_POST['llantas'] : null;
    $rines = isset($_POST['rines']) ? $_POST['rines'] : null;
    $tapones = isset($_POST['tapones']) ? $_POST['tapones'] : null;
    $amortiguadores = isset($_POST['amortiguadores']) ? $_POST['amortiguadores'] : null;
    $cristales = isset($_POST['cristales']) ? $_POST['cristales'] : null;
    $parabrisas = isset($_POST['parabrisas']) ? $_POST['parabrisas'] : null;
    $E_retrovisor = isset($_POST['E_retrovisor']) ? $_POST['E_retrovisor'] : null;
    $E_lateral = isset($_POST['E_lateral']) ? $_POST['E_lateral'] : null;
    $salpicaderas = isset($_POST['salpicaderas']) ? $_POST['salpicaderas'] : null;
    $portezuela = isset($_POST['portezuela']) ? $_POST['portezuela'] : null;
    $cofre = isset($_POST['cofre']) ? $_POST['cofre'] : null;
    $cajuela = isset($_POST['cajuela']) ? $_POST['cajuela'] : null;
    $defensa = isset($_POST['defensa']) ? $_POST['defensa'] : null;
    $t_gasolina = isset($_POST['t_gasolina']) ? $_POST['t_gasolina'] : null;
    $vestidura = isset($_POST['vestidura']) ? $_POST['vestidura'] : null;
    $tapiceria = isset($_POST['tapiceria']) ? $_POST['tapiceria'] : null;
    $asientos = isset($_POST['asientos']) ? $_POST['asientos'] : null;
    $c_seguridad = isset($_POST['c_seguridad']) ? $_POST['c_seguridad'] : null;
    $viceras = isset($_POST['viceras']) ? $_POST['viceras'] : null;
    $guantera = isset($_POST['guantera']) ? $_POST['guantera'] : null;
    $t_circulacion = isset($_POST['t_circulacion']) ? $_POST['t_circulacion'] : null;
    $p_seguro = isset($_POST['p_seguro']) ? $_POST['p_seguro'] : null;
    $manual = isset($_POST['manual']) ? $_POST['manual'] : null;
    $herramienta = isset($_POST['herramienta']) ? $_POST['herramienta'] : null;
    $gato = isset($_POST['gato']) ? $_POST['gato'] : null;
    $llave_cruz = isset($_POST['llave_cruz']) ? $_POST['llave_cruz'] : null;
    $t_seguridad = isset($_POST['t_seguridad']) ? $_POST['t_seguridad'] : null;
    $c_corriente = isset($_POST['c_corriente']) ? $_POST['c_corriente'] : null;
    $extinguidor = isset($_POST['extinguidor']) ? $_POST['extinguidor'] : null;

     // El campo 'nota' es un campo de texto
     $nota = isset($_POST['nota']) ? $_POST['nota'] : null;

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO inventario_detalle 
        (motor, transmision, direccion, frenos, electrico, faros, calaveras, direccionales, intermitentes, radio, reloj, limpiadores, antena, tapetes, llanta_refaccion, llantas, rines, tapones, amortiguadores, cristales, parabrisas, E_retrovisor, E_lateral, salpicaderas, portezuela, cofre, cajuela, defensa, t_gasolina, vestiduras, tapiceria, asientos, c_seguridad, viceras, guantera, t_circulacion, p_seguro, manuales, herramienta, gato, llave_cruz, t_seguridad, c_corriente, extinguidor, nota)
        VALUES 
        (:motor, :transmision, :direccion, :frenos, :electrico, :faros, :calaveras, :direccionales, :intermitentes, :radio, :reloj, :limpiadores, :antena, :tapetes, :llanta_refaccion, :llantas, :rines, :tapones, :amortiguadores, :cristales, :parabrisas, :E_retrovisor, :E_lateral, :salpicaderas, :portezuela, :cofre, :cajuela, :defensa, :t_gasolina, :vestidura, :tapiceria, :asientos, :c_seguridad, :viceras, :guantera, :t_circulacion, :p_seguro, :manual, :herramienta, :gato, :llave_cruz, :t_seguridad, :c_corriente, :extinguidor, :nota)";

    // Preparar la consulta para ser ejecutada
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta con los valores recogidos
    $stmt->execute([
        ':motor' => $motor,
        ':transmision' => $transmision,
        ':direccion' => $direccion,
        ':frenos' => $frenos,
        ':electrico' => $electrico,
        ':faros' => $faros,
        ':calaveras' => $calaveras,
        ':direccionales' => $direccionales,
        ':intermitentes' => $intermitentes,
        ':radio' => $radio,
        ':reloj' => $reloj,
        ':limpiadores' => $limpiadores,
        ':antena' => $antena,
        ':tapetes' => $tapetes,
        ':llanta_refaccion' => $llanta_refaccion,
        ':llantas' => $llantas,
        ':rines' => $rines,
        ':tapones' => $tapones,
        ':amortiguadores' => $amortiguadores,
        ':cristales' => $cristales,
        ':parabrisas' => $parabrisas,
        ':E_retrovisor' => $E_retrovisor,
        ':E_lateral' => $E_lateral,
        ':salpicaderas' => $salpicaderas,
        ':portezuela' => $portezuela,
        ':cofre' => $cofre,
        ':cajuela' => $cajuela,
        ':defensa' => $defensa,
        ':t_gasolina' => $t_gasolina,
        ':vestidura' => $vestidura,
        ':tapiceria' => $tapiceria,
        ':asientos' => $asientos,
        ':c_seguridad' => $c_seguridad,
        ':viceras' => $viceras,
        ':guantera' => $guantera,
        ':t_circulacion' => $t_circulacion,
        ':p_seguro' => $p_seguro,
        ':manual' => $manual,
        ':herramienta' => $herramienta,
        ':gato' => $gato,
        ':llave_cruz' => $llave_cruz,
        ':t_seguridad' => $t_seguridad,
        ':c_corriente' => $c_corriente,
        ':extinguidor' => $extinguidor,
        ':nota' => $nota
    ]);

        // Obtener el último ID insertado (el ID del inventario)
        $id_inventario = $pdo->lastInsertId();

 // Mostrar mensaje de éxito y redirigir a la página 'supervision.php'
 echo "
 <html>
 <head>
     <style>
         /* Estilo para la ventana modal */
         .modal {
             display: none; /* Inicialmente oculto */
             position: fixed;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro */
             z-index: 1000;
             justify-content: center;
             align-items: center;
         }

         .modal-content {
             background-color: #fff;
             padding: 20px;
             border-radius: 5px;
             text-align: center;
             width: 300px;
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
         }

         .modal-button {
             padding: 10px 20px;
             background-color: #28a745;
             color: white;
             border: none;
             cursor: pointer;
             border-radius: 5px;
             font-size: 16px;
         }

         .modal-button:hover {
             background-color: #218838;
         }
     </style>
     <script>
         window.onload = function() {
             // Mostrar la ventana modal
             var modal = document.getElementById('successModal');
             modal.style.display = 'flex';

             // Redirigir después de 2 segundos
             setTimeout(function() {
                 window.location.href = 'supervision.php?id_inventario=' + $id_inventario;
             }, 2000);
         }
     </script>
 </head>
 <body>
     <!-- Ventana Modal -->
     <div id='successModal' class='modal'>
         <div class='modal-content'>
             <h2>¡Tus datos se guardaron correctamente!</h2>
             <button class='modal-button'>Cerrar</button>
         </div>
     </div>
 </body>
 </html>
";

}
?>
