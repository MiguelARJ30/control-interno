<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirige al login si no está logueado
    exit();
}

$usuario = $_SESSION['user']; // Obtener el nombre de usuario desde la sesión
?>
<!DOCTYPE html>
<html lang="en">
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
                <!-- Columna 1 -->
                <div class="col-md-4">
                    <div class="mb-3"><label><strong>Motor</strong></label><br>
                        <input type="radio" name="motor" value="BE"> B/E
                        <input type="radio" name="motor" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Transmisión</strong></label><br>
                        <input type="radio" name="transmision" value="BE"> B/E
                        <input type="radio" name="transmision" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Dirección</strong></label><br>
                        <input type="radio" name="direccion" value="BE"> B/E
                        <input type="radio" name="direccion" value="ME"> M/E
                    </div>
                    <!-- Agrega el resto de los atributos en esta columna siguiendo el mismo patrón -->
                    <div class="mb-3"><label><strong>Frenos</strong></label><br>
                        <input type="radio" name="frenos" value="BE"> B/E
                        <input type="radio" name="frenos" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Eléctrico</strong></label><br>
                        <input type="radio" name="electrico" value="BE"> B/E
                        <input type="radio" name="electrico" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Faros</strong></label><br>
                        <input type="radio" name="faros" value="BE"> B/E
                        <input type="radio" name="faros" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Calaveras</strong></label><br>
                        <input type="radio" name="calaveras" value="BE"> B/E
                        <input type="radio" name="calaveras" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Direccionales</strong></label><br>
                        <input type="radio" name="direccionales" value="BE"> B/E
                        <input type="radio" name="direccionales" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Intermitentes</strong></label><br>
                        <input type="radio" name="intermitentes" value="BE"> B/E
                        <input type="radio" name="intermitentes" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Radio</strong></label><br>
                        <input type="radio" name="radio" value="BE"> B/E
                        <input type="radio" name="radio" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Reloj</strong></label><br>
                        <input type="radio" name="reloj" value="BE"> B/E
                        <input type="radio" name="reloj" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Limpiadores</strong></label><br>
                        <input type="radio" name="limpiadores" value="BE"> B/E
                        <input type="radio" name="limpiadores" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Antena</strong></label><br>
                        <input type="radio" name="antena" value="BE"> B/E
                        <input type="radio" name="antena" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Tapetes</strong></label><br>
                        <input type="radio" name="tapetes" value="BE"> B/E
                        <input type="radio" name="tapetes" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Llanta de Refacción</strong></label><br>
                        <input type="radio" name="llanta_refaccion" value="BE"> B/E
                        <input type="radio" name="llanta_refaccion" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Llantas</strong></label><br>
                        <input type="radio" name="llantas" value="BE"> B/E
                        <input type="radio" name="llantas" value="ME"> M/E
                    </div>
                </div>

                <!-- Columna 2 -->
                <div class="col-md-4">
                    <div class="mb-3"><label><strong>Rines</strong></label><br>
                        <input type="radio" name="rines" value="BE"> B/E
                        <input type="radio" name="rines" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Tapones</strong></label><br>
                        <input type="radio" name="tapones" value="BE"> B/E
                        <input type="radio" name="tapones" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Amortiguadores</strong></label><br>
                        <input type="radio" name="amortiguadores" value="BE"> B/E
                        <input type="radio" name="amortiguadores" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Cristales</strong></label><br>
                        <input type="radio" name="cristales" value="BE"> B/E
                        <input type="radio" name="cristales" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Parabrisas</strong></label><br>
                        <input type="radio" name="parabrisas" value="BE"> B/E
                        <input type="radio" name="parabrisas" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Espejo Retrovisor</strong></label><br>
                        <input type="radio" name="E_retrovisor" value="BE"> B/E
                        <input type="radio" name="E_retrovisor" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Espejo Lateral</strong></label><br>
                        <input type="radio" name="E_lateral" value="BE"> B/E
                        <input type="radio" name="E_lateral" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Salpicaderas</strong></label><br>
                        <input type="radio" name="salpicaderas" value="BE"> B/E
                        <input type="radio" name="salpicaderas" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Portezuelas</strong></label><br>
                        <input type="radio" name="portezuela" value="BE"> B/E
                        <input type="radio" name="portezuela" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Cofre</strong></label><br>
                        <input type="radio" name="cofre" value="BE"> B/E
                        <input type="radio" name="cofre" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Cajuela</strong></label><br>
                        <input type="radio" name="cajuela" value="BE"> B/E
                        <input type="radio" name="cajuela" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Defensa</strong></label><br>
                        <input type="radio" name="defensa" value="BE"> B/E
                        <input type="radio" name="defensa" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Tapon de gasolina</strong></label><br>
                        <input type="radio" name="t_gasolina" value="BE"> B/E
                        <input type="radio" name="t_gasolina" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Vestidura</strong></label><br>
                        <input type="radio" name="vestidura" value="BE"> B/E
                        <input type="radio" name="vestidura" value="ME"> M/E
                    </div> 
                    <div class="mb-3"><label><strong>Tapiceria</strong></label><br>
                        <input type="radio" name="tapiceria" value="BE"> B/E
                        <input type="radio" name="tapiceria" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Asientos</strong></label><br>
                        <input type="radio" name="asientos" value="BE"> B/E
                        <input type="radio" name="asientos" value="ME"> M/E
                    </div>
                    <!-- Continúa con los elementos restantes en esta columna -->
                </div>

                <!-- Columna 3 -->
                <div class="col-md-4">
                    <div class="mb-3"><label><strong>Cinturon de seguridad</strong></label><br>
                        <input type="radio" name="c_seguridad" value="BE"> B/E
                        <input type="radio" name="c_seguridad" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Viceras</strong></label><br>
                        <input type="radio" name="viceras" value="BE"> B/E
                        <input type="radio" name="viceras" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Guantera</strong></label><br>
                        <input type="radio" name="guantera" value="BE"> B/E
                        <input type="radio" name="guantera" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Tarjeta de circulacion</strong></label><br>
                        <input type="radio" name="t_circulacion" value="BE"> B/E
                        <input type="radio" name="t_circulacion" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Poliza de seguro</strong></label><br>
                        <input type="radio" name="p_seguro" value="BE"> B/E
                        <input type="radio" name="p_seguro" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Manual</strong></label><br>
                        <input type="radio" name="manual" value="BE"> B/E
                        <input type="radio" name="manual" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Herramienta</strong></label><br>
                        <input type="radio" name="herramienta" value="BE"> B/E
                        <input type="radio" name="herramienta" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Gato</strong></label><br>
                        <input type="radio" name="gato" value="BE"> B/E
                        <input type="radio" name="gato" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Llave de cruz</strong></label><br>
                        <input type="radio" name="llave_cruz" value="BE"> B/E
                        <input type="radio" name="llave_cruz" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Tarjeta de seguridad</strong></label><br>
                        <input type="radio" name="t_seguridad" value="BE"> B/E
                        <input type="radio" name="t_seguridad" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Cables de corriente</strong></label><br>
                        <input type="radio" name="c_corriente" value="BE"> B/E
                        <input type="radio" name="c_corriente" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label><strong>Extinguidor</strong></label><br>
                        <input type="radio" name="extinguidor" value="BE"> B/E
                        <input type="radio" name="extinguidor" value="ME"> M/E
                    </div>
                    <div class="mb-3"><label for="nota"><strong>Nota:</strong></label><br>
                    <input type="text" name="nota" id="nota"></>    
                    </div>                                     
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-warning" onclick="selectAllBE()">Seleccionar Todos B/E</button>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>
    <script>
        // Función que selecciona todos los radio buttons con el valor 'BE'
        function selectAllBE() {
            const radios = document.querySelectorAll('input[type="radio"][value="BE"]');
            radios.forEach(radio => radio.checked = true);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
