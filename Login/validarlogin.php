<?php
    // Inicializar variables
    $usuario = $_POST["username"] ?? "";
    $contrasena = $_POST["password"] ?? "";
    $errores = [];

    // Procesar solo si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Validar usuario
        if ($usuario === "") {
            $errores[] = "El nombre de usuario es obligatorio.";
        } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $usuario)) {
            $errores[] = "El nombre de usuario solo puede contener letras y números.";
        } elseif (strlen($usuario) < 3 || strlen($usuario) > 20) {
            $errores[] = "El nombre de usuario debe tener entre 3 y 20 caracteres.";
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

        // Si no hay errores, mostrar mensaje de éxito
        if (empty($errores)) {
            $mensaje_exito = "Inicio de sesión correcto. Bienvenido, $usuario.";
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
                <a href="../Reserva/reserva.html">Reserva de pistas</a>
                <a href="../Jugadores/jugadores.html">Ranking de jugadores</a>
                <a href="../Clases/clases.html">Clases</a>
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

            <!-- Mostrar mensaje de éxito -->
            <?php if (!empty($mensaje_exito)): ?>
                <div style="color: green; margin-bottom: 15px;">
                    <p><?= $mensaje_exito ?></p>
                </div>
            <?php endif; ?>

            <div class="login">
                <form action="" method="post">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($usuario) ?>"><br>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password"><br>

                    <div class="recordarme">
                        <input type="checkbox" id="remember" name="remember">
                        <span>Recordarme</span>
                    </div>

                    <br>
                    <button type="submit">Iniciar sesión</button>
                </form>

                <p>¿No tienes una cuenta? <a href="registrarse.html">Regístrate aquí</a></p>
            </div>
        </div>

        <footer>
            <p>© 2025 Padelorgaz.</p>
        </footer>

    </body>
</html>
