<?php
session_start();

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verifica si el usuario ya está logueado
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php'); // Redirige a una página protegida si ya está logueado
    exit();
}

$error = ''; // Mensaje de error si no es válido el login

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password_usuario = $_POST['password'] ?? '';

    // Consulta SQL para verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si el usuario existe y si la contraseña es correcta
    if ($user && password_verify($password_usuario, $user['password'])) {
        // Si las credenciales son correctas, guarda el usuario en la sesión
        $_SESSION['user'] = $user['usuario'];
        $_SESSION['id_puesto'] = $user['id_puesto'];
        header('Location: dashboard.php'); // Redirige a la página protegida
        exit();
    } else {
        // Si las credenciales no son correctas
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <!-- Vinculando Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Vinculando iconos de Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .vh-100 {
            height: 100vh;
        }
        .form-outline {
            margin-bottom: 1.5rem;
        }
        .divider:after,
.divider:before {
content: "";
flex: 1;
height: 1px;
background: #eee;
}
.h-custom {
height: calc(100% - 73px);
}
@media (max-width: 450px) {
.h-custom {
height: 100%;
}
}
    </style>
</head>
<body>
<section class="vh-100" style="background-color: white">
<div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-2 px-3 px-xl-4" style="background-color: #472681;">
</div>
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <!-- Imagen del lado izquierdo -->
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="imagenes/trasla.png" class="img-fluid" alt="Imagen de inicio" style="width: 70%px; height: 20%px;">
      </div>
      
      <!-- Formulario de login -->
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form action="index.php" method="POST">
          <h3 class="text-center mb-4" style="color: black;">Iniciar sesión</h3>
          
          <!-- Mostrar mensaje de error si las credenciales son incorrectas -->
          <?php if ($error): ?>
            <div class="alert alert-danger">
              <?php echo $error; ?>
            </div>
          <?php endif; ?>

          <!-- Ingreso del Usuario -->
          <div class="form-outline mb-4">
          <label class="form-label" for="usuario" style="color: black; font-size: 20px;">Usuario</label>
            <input type="text" id="usuario" name="usuario" class="form-control form-control-lg" style="border: 2px solid black; border-radius: 50px;" placeholder="Ingresa tu usuario" required>
          </div>

          <!-- Ingreso de la Contraseña -->
          <div class="form-outline mb-4">
          <label class="form-label" for="password" style="color: black; font-size: 20px;">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control form-control-lg" style="border: 2px solid black; border-radius: 50px;" placeholder="Ingresa tu contraseña" required>
          </div>

          <!-- Botón de Iniciar sesión -->
          <div class="d-flex justify-content-center align-items-center">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 40%; background-color: #472681; border:none; border-radius: 50px;">Iniciar sesión</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Pie de página -->
  <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-3 px-3 px-xl-4" style="background-color: #472681;">
    <div class="text-white mb-3 mb-md-0">
      Copyright © 2024. Todos los derechos reservados.
    </div>
    <div>
      <a href="https://www.facebook.com/people/Trasla/61566962580927/?mibextid=LQQJ4d" class="text-white me-4"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="text-white me-4"><i class="fab fa-twitter"></i></a>
      <a href="#" class="text-white me-4"><i class="fab fa-google"></i></a>
      <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
    </div>
  </div>
</section>

<!-- Vinculando los scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
