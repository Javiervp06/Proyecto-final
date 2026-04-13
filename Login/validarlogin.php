<?php
session_start();
require_once "../bdd/config.php";

// Inicializar variables
$usuario = $_POST["email"] ?? "";
$contrasena = $_POST["password"] ?? "";
$errores = [];
$mensaje_exito = "";

// Procesar solo si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // VALIDACIONES TUYAS (NO TOCO NADA)

    // Validar usuario (email)
    if ($usuario === "") {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    // Validar contraseña
    if ($contrasena === "") {
        $errores[] = "La contraseña es obligatoria.";
    } elseif (strlen($contrasena) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    } elseif (!preg_match("/[A-Z]/", $contrasena)) {
        $errores[] = "La contraseña debe contener al menos una letra mayúscula.";
    } elseif (!preg_match("/[a-z]/", $contrasena)) {
        $errores[] = "La contraseña debe contener al menos una letra minúscula.";
    } elseif (!preg_match("/[0-9]/", $contrasena)) {
        $errores[] = "La contraseña debe contener al menos un número.";
    }

    // SI NO HAY ERRORES → HACER LOGIN REAL
    if (empty($errores)) {

        $email = $usuario;

        // Buscar usuario por email
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows === 1) {

            $datos = $resultado->fetch_assoc();

            // Verificar contraseña encriptada
            if (password_verify($contrasena, $datos["password"])) {

                // Crear sesión
                $_SESSION["usuario_id"] = $datos["id"];
                $_SESSION["usuario_nombre"] = $datos["nombre"];
                $_SESSION["usuario_alias"] = $datos["alias"];

                // Redirigir al inicio
                header("Location: ../Pantalla_inicio/inicio.html");
                exit;

            } else {
                $errores[] = "Usuario o contraseña incorrectos.";
            }

        } else {
            $errores[] = "Usuario o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz - Inicio de sesión</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
</head>

<body>
    <header>
        <img src="../Imágenes/Logopaginaweb.png" alt="Logo de Torreorgaz" class="logo">
        <p>C. la Trancha, 0, 10182 Torreorgaz, Cáceres<br>665 33 37 91 
            <img src="../Imágenes/whatsapp.jpg">
            <img src="../Imágenes/telefonos.png"> 
            <br> Jvidartep05@educarex.es <img src="../Imágenes/gmail.png">
        </p>
    </header>

    <div id="contenedor">
        <div id="menu">
            <a href="../Pantalla_inicio/inicio.html">Inicio</a>
            <a href="../Reserva/reserva.php">Reserva de pistas</a>
            <a href="../Jugadores/jugadores.php">Ranking de jugadores</a>
            <a href="../Clases/clases.php">Clases</a>
            <a href="../Información/informacion.html">Información</a>
            <a href="../Login/login.php" class="activo">Inicio de sesión</a>
        </div>
    </div>

    <div id="recuadro">
        <h2>Inicio de sesión</h2>

        <!-- Mostrar errores -->
        <?php if (!empty($errores)): ?>
            <div style="color: red; margin-bottom: 15px;">
                <?php foreach ($errores as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="login">
            <form action="" method="post">
                <label for="email">Correo electrónico:</label>
                <input type="text" id="email" name="email" value="<?= htmlspecialchars($usuario) ?>"><br>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password"><br>

                <div class="recordarme">
                    <input type="checkbox" id="remember" name="remember">
                    <span>Recordarme</span>
                </div>

                <br>
                <button type="submit">Iniciar sesión</button>
            </form>

            <p>¿No tienes una cuenta? <a href="registrarse.php">Regístrate aquí</a></p>
        </div>
    </div>

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

</body>
</html>
