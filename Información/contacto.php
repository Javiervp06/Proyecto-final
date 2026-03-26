<?php
// Inicializar variables
$nombre = $_POST["nombre"] ?? "";
$telefono = $_POST["telefono"] ?? "";
$asunto = $_POST["asunto"] ?? "";
$correo = $_POST["correo"] ?? "";
$mensaje = $_POST["mensaje"] ?? "";
$errores = [];
$mensaje_exito = "";

// Procesar solo si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar nombre
    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    }

    // Validar teléfono
    if (!preg_match("/^[0-9]{9}$/", $telefono)) {
        $errores[] = "El teléfono debe tener 9 números.";
    }

    // Validar asunto
    if ($asunto === "") {
        $errores[] = "El asunto es obligatorio.";
    } elseif (!preg_match("/^(?=.*[a-zA-ZáéíóúÁÉÍÓÚñÑ])[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]+$/u", $asunto)) {
        $errores[] = "El asunto debe contener letras y puede incluir números, pero no puede ser solo números.";
    }

    // Validar correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    // Validar mensaje
    if ($mensaje === "") {
        $errores[] = "El mensaje es obligatorio.";
    }

    // Si no hay errores → éxito
    if (empty($errores)) {
        $mensaje_exito = "Mensaje enviado correctamente. Gracias por contactar con nosotros, $nombre.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Contacto</title>
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
            <a href="../Información/informacion.html" class="activo">Información</a>
            <a href="../Login/login.php">Inicio de sesión</a>
        </div>
    </div>

    <div id="recuadro">
        <div id="recuadroinfo">
            <div id="informacion">
                <p id="parrafito">Acerca de nosotros:</p>
                <a href="informacion.html">1. ¿Dónde estamos?</a><br>
                <a href="normas.html">2. Normas</a><br>
                <a href="anulacion.html">3. Reservas y anulaciones</a><br>
                <a href="tarifas.html">4. Tarifas</a><br>
                <a href="servicios.html">5. Servicios</a><br>
                <a href="contacto.php" class="activo">6. Contacto</a>
            </div>

            <div class="contenido">
                <h2>6. Contacto</h2>
                <p>En este apartado puedes enviarnos tus quejas, reclamaciones, sugerencias o cualquier otro tipo de mensaje.</p>

                <!-- Mostrar errores -->
                <?php if (!empty($errores)): ?>
                    <div style="color: red; margin-bottom: 15px;">
                        <?php foreach ($errores as $error): ?>
                            <p><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Mostrar mensaje de éxito -->
                <?php if ($mensaje_exito): ?>
                    <div style="color: green; margin-bottom: 15px;">
                        <p><?= $mensaje_exito ?></p>
                    </div>
                <?php endif; ?>

                <div id="recuadrocontacto">
                    <form action="" method="post">

                        <div class="fila">
                            <label for="nombre"><div class="asterisco">*</div> Nombre:</label>
                            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
                        </div>

                        <div class="fila">
                            <label for="telefono"><div class="asterisco">*</div> Teléfono:</label>
                            <input type="number" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono) ?>">
                        </div>

                        <div class="fila">
                            <label for="asunto"><div class="asterisco">*</div> Asunto:</label>
                            <input type="text" id="asunto" name="asunto" value="<?= htmlspecialchars($asunto) ?>">
                        </div>

                        <div class="fila">
                            <label for="correo"><div class="asterisco">*</div> Correo electrónico:</label>
                            <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>">
                        </div>

                        <div class="fila-mensaje">
                            <label for="mensaje"><div class="asterisco">*</div> Mensaje:</label>
                            <textarea id="mensaje" name="mensaje"><?= htmlspecialchars($mensaje) ?></textarea>
                        </div>

                        <button type="submit">Enviar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

</body>
</html>
