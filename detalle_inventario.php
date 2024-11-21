<?php
include('conexion.php'); // Incluir archivo de conexión

// Obtener el id_inventario de la URL
if (isset($_GET['id_inventario'])) {
    $id_inventario = $_GET['id_inventario'];

    // Preparar y ejecutar la consulta
    $sql = "SELECT * FROM inventario_detalle WHERE id_inventario = :id_inventario";
    $stmt = $pdo->prepare($sql); // Usar el objeto PDO para preparar la consulta
    $stmt->bindParam(':id_inventario', $id_inventario, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener los resultados
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar si se encontraron resultados
    if ($resultado) {

        $motor = $resultado['motor'];
        $transmision = $resultado['transmision'];
        $direccion = $resultado['direccion'];
        $frenos = $resultado['frenos'];
        $electrico = $resultado['electrico'];
        $faros = $resultado['faros'];
        $calaveras = $resultado['calaveras'];
        $direccionales = $resultado['direccionales'];
        $intermitentes = $resultado['intermitentes'];
        $radio = $resultado['radio'];
        $reloj = $resultado['reloj'];
        $limpiadores = $resultado['limpiadores'];
        $antena = $resultado['antena'];
        $tapetes = $resultado['tapetes'];
        $llanta_refaccion = $resultado['llanta_refaccion'];
        $llantas = $resultado['llantas'];
        $rines = $resultado['rines'];
        $tapones = $resultado['tapones'];
        $amortiguadores = $resultado['amortiguadores'];
        $cristales = $resultado['cristales'];
        $parabrisas = $resultado['parabrisas'];
        $E_retrovisor = $resultado['E_retrovisor'];
        $E_lateral = $resultado['E_lateral'];
        $salpicaderas = $resultado['salpicaderas'];
        $portezuela = $resultado['portezuela'];
        $cofre = $resultado['cofre'];
        $cajuela = $resultado['cajuela'];
        $defensa = $resultado['defensa'];
        $t_gasolina = $resultado['t_gasolina'];
        $vestiduras = $resultado['vestiduras'];
        $tapiceria = $resultado['tapiceria'];
        $asientos = $resultado['asientos'];
        $c_seguridad = $resultado['c_seguridad'];
        $viceras = $resultado['viceras'];
        $guantera = $resultado['guantera'];
        $t_circulacion = $resultado['t_circulacion'];
        $p_seguro = $resultado['p_seguro'];
        $manuales = $resultado['manuales'];
        $herramienta = $resultado['herramienta'];
        $gato = $resultado['gato'];
        $llave_cruz = $resultado['llave_cruz'];
        $t_seguridad = $resultado['t_seguridad'];
        $c_corriente = $resultado['c_corriente'];
        $extinguidor = $resultado['extinguidor'];
        $nota = $resultado['nota'];

    } else {
        echo "No se encontraron resultados.";
    }
} else {
    echo "No se proporcionó un id_inventario.";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inspección de Vehículo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Formulario de Inspección de Vehículo</h2>
        <form action="procesar_formulario.php" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <!-- Motor -->
                    <div class="mb-1">
                        <label><strong>Motor</strong></label><br>
                        <input type="radio" name="motor" value="BE" <?php echo ($motor == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="motor" value="ME" <?php echo ($motor == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <!-- Transmisión -->
                    <div class="mb-1">
                        <label><strong>Transmisión</strong></label><br>
                        <input type="radio" name="transmision" value="BE" <?php echo ($transmision == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="transmision" value="ME" <?php echo ($transmision == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <!-- Dirección -->
                    <div class="mb-1">
                        <label><strong>Dirección</strong></label><br>
                        <input type="radio" name="direccion" value="BE" <?php echo ($direccion == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="direccion" value="ME" <?php echo ($direccion == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <!-- Frenos -->
                    <div class="mb-1">
                        <label><strong>Frenos</strong></label><br>
                        <input type="radio" name="frenos" value="BE" <?php echo ($frenos == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="frenos" value="ME" <?php echo ($frenos == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <!-- Eléctrico -->
                    <div class="mb-1">
                        <label><strong>Eléctrico</strong></label><br>
                        <input type="radio" name="electrico" value="BE" <?php echo ($electrico == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="electrico" value="ME" <?php echo ($electrico == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Faros</strong></label><br>
                        <input type="radio" name="faros" value="BE" <?php echo ($faros == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="faros" value="ME" <?php echo ($faros == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Calaveras</strong></label><br>
                        <input type="radio" name="calaveras" value="BE" <?php echo ($calaveras == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="calaveras" value="ME" <?php echo ($calaveras == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Direccionales</strong></label><br>
                        <input type="radio" name="direccionales" value="BE" <?php echo ($direccionales == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="direccionales" value="ME" <?php echo ($direccionales == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Intermitentes</strong></label><br>
                        <input type="radio" name="intermitentes" value="BE" <?php echo ($intermitentes == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="intermitentes" value="ME" <?php echo ($intermitentes == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Radio</strong></label><br>
                        <input type="radio" name="radio" value="BE" <?php echo ($radio == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="radio" value="ME" <?php echo ($radio == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Reloj</strong></label><br>
                        <input type="radio" name="reloj" value="BE" <?php echo ($reloj == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="reloj" value="ME" <?php echo ($reloj == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>
                    <div class="mb-1">
                        <label><strong>Limpiadores</strong></label><br>
                        <input type="radio" name="limpiadores" value="BE" <?php echo ($limpiadores == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="limpiadores" value="ME" <?php echo ($limpiadores == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>
                </div>

                <!-- Columna 2 -->
                <div class="col-md-3">
                    <div class="mb-1">
                        <label><strong>Antena</strong></label><br>
                        <input type="radio" name="antena" value="BE" <?php echo ($antena == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="antena" value="ME" <?php echo ($antena == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Tapetes</strong></label><br>
                        <input type="radio" name="tapetes" value="BE" <?php echo ($tapetes == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="tapetes" value="ME" <?php echo ($tapetes == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Llanta Refacción</strong></label><br>
                        <input type="radio" name="llanta_refaccion" value="BE" <?php echo ($llanta_refaccion == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="llanta_refaccion" value="ME" <?php echo ($llanta_refaccion == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Llanta</strong></label><br>
                        <input type="radio" name="llantas" value="BE" <?php echo ($llantas == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="llantas" value="ME" <?php echo ($llantas == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>
                    <div class="mb-1">
                        <label><strong>Rines</strong></label><br>
                        <input type="radio" name="rines" value="BE" <?php echo ($rines == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="rines" value="ME" <?php echo ($rines == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Tapones</strong></label><br>
                        <input type="radio" name="tapones" value="BE" <?php echo ($tapones == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="tapones" value="ME" <?php echo ($tapones == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Amortiguadores</strong></label><br>
                        <input type="radio" name="amortiguadores" value="BE" <?php echo ($amortiguadores == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="amortiguadores" value="ME" <?php echo ($amortiguadores == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Cristales</strong></label><br>
                        <input type="radio" name="cristales" value="BE" <?php echo ($cristales == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="cristales" value="ME" <?php echo ($cristales == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Parabrisas</strong></label><br>
                        <input type="radio" name="parabrisas" value="BE" <?php echo ($parabrisas == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="parabrisas" value="ME" <?php echo ($parabrisas == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Espejo Retrovisor</strong></label><br>
                        <input type="radio" name="E_retrovisor" value="BE" <?php echo ($E_retrovisor == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="E_retrovisor" value="ME" <?php echo ($E_retrovisor == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>
                    <div class="mb-1">
                        <label><strong>Espejo Lateral</strong></label><br>
                        <input type="radio" name="E_lateral" value="BE" <?php echo ($E_lateral == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="E_lateral" value="ME" <?php echo ($E_lateral == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Salpicaderas</strong></label><br>
                        <input type="radio" name="salpicaderas" value="BE" <?php echo ($salpicaderas == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="salpicaderas" value="ME" <?php echo ($salpicaderas == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>
                </div>

                <!-- Columna 2 -->
                <div class="col-md-3">
                    <div class="mb-1">
                        <label><strong>Portezuela</strong></label><br>
                        <input type="radio" name="portezuela" value="BE" <?php echo ($portezuela == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="portezuela" value="ME" <?php echo ($portezuela == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Cofre</strong></label><br>
                        <input type="radio" name="cofre" value="BE" <?php echo ($cofre == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="cofre" value="ME" <?php echo ($cofre == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Cajuela</strong></label><br>
                        <input type="radio" name="cajuela" value="BE" <?php echo ($cajuela == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="cajuela" value="ME" <?php echo ($cajuela == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Defensa</strong></label><br>
                        <input type="radio" name="defensa" value="BE" <?php echo ($defensa == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="defensa" value="ME" <?php echo ($defensa == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Tanque de Gasolina</strong></label><br>
                        <input type="radio" name="t_gasolina" value="BE" <?php echo ($t_gasolina == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="t_gasolina" value="ME" <?php echo ($t_gasolina == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Vestiduras</strong></label><br>
                        <input type="radio" name="vestiduras" value="BE" <?php echo ($vestiduras == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="vestiduras" value="ME" <?php echo ($vestiduras == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Tapicería</strong></label><br>
                        <input type="radio" name="tapiceria" value="BE" <?php echo ($tapiceria == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="tapiceria" value="ME" <?php echo ($tapiceria == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Asientos</strong></label><br>
                        <input type="radio" name="asientos" value="BE" <?php echo ($asientos == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="asientos" value="ME" <?php echo ($asientos == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>
                    <div class="mb-1">
                        <label><strong>Cinturón de Seguridad</strong></label><br>
                        <input type="radio" name="c_seguridad" value="BE" <?php echo ($c_seguridad == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="c_seguridad" value="ME" <?php echo ($c_seguridad == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>
                    <div class="mb-1">
                        <label><strong>Viceras</strong></label><br>
                        <input type="radio" name="viceras" value="BE" <?php echo ($viceras == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="viceras" value="ME" <?php echo ($viceras == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Guatera</strong></label><br>
                        <input type="radio" name="guantera" value="BE" <?php echo ($guantera == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="guantera" value="ME" <?php echo ($guantera == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Tarjeta de Circulación</strong></label><br>
                        <input type="radio" name="t_circulacion" value="BE" <?php echo ($t_circulacion == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="t_circulacion" value="ME" <?php echo ($t_circulacion == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>
                    </div>

                    <!-- Columna 2 -->
                    <div class="col-md-3">
                    <div class="mb-1">
                        <label><strong>Póliza de Seguro</strong></label><br>
                        <input type="radio" name="p_seguro" value="BE" <?php echo ($p_seguro == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="p_seguro" value="ME" <?php echo ($p_seguro == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Manuales</strong></label><br>
                        <input type="radio" name="manuales" value="BE" <?php echo ($manuales == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="manuales" value="ME" <?php echo ($manuales == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Herramienta</strong></label><br>
                        <input type="radio" name="herramienta" value="BE" <?php echo ($herramienta == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="herramienta" value="ME" <?php echo ($herramienta == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Gato</strong></label><br>
                        <input type="radio" name="gato" value="BE" <?php echo ($gato == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="gato" value="ME" <?php echo ($gato == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Llave Cruz</strong></label><br>
                        <input type="radio" name="llave_cruz" value="BE" <?php echo ($llave_cruz == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="llave_cruz" value="ME" <?php echo ($llave_cruz == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Tipo de Seguridad</strong></label><br>
                        <input type="radio" name="t_seguridad" value="BE" <?php echo ($t_seguridad == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="t_seguridad" value="ME" <?php echo ($t_seguridad == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Corriente Ascendente</strong></label><br>
                        <input type="radio" name="c_corriente" value="BE" <?php echo ($c_corriente == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="c_corriente" value="ME" <?php echo ($c_corriente == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Extintor</strong></label><br>
                        <input type="radio" name="extinguidor" value="BE" <?php echo ($extinguidor == 'BE') ? 'checked disabled' : 'disabled'; ?>> B/E
                        <input type="radio" name="extinguidor" value="ME" <?php echo ($extinguidor == 'ME') ? 'checked disabled' : 'disabled'; ?>> M/E
                    </div>

                    <div class="mb-1">
                        <label><strong>Nota</strong></label><br>
                        <input type="text" name="nota" value="<?php echo $nota; ?>" class="form-control" <?php echo ($nota != '') ? 'disabled' : ''; ?>>
                    </div>


                </div>
            </div>

        </form>
    </div>
</body>
</html>
