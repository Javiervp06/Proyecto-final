<?php
// Inicializar variables
$nombre = $_POST["nombre"] ?? "";
$telefono = $_POST["telefono"] ?? "";
$correo = $_POST["correo"] ?? "";
$mensaje = $_POST["mensaje"] ?? "";
$errores = [];
$mensaje_exito = "";

// Procesar solo si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar nombre
    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    } elseif (strlen($nombre) < 3 || strlen($nombre) > 20) {
        $errores[] = "El nombre debe tener entre 3 y 20 caracteres.";
    }

    // Validar teléfono
    if (!preg_match("/^[0-9]{9}$/", $telefono)) {
        $errores[] = "El teléfono debe tener 9 números.";
    }

    // Validar correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    // Validar mensaje
    if ($mensaje === "") {
        $errores[] = "Los datos de interés son obligatorios.";
    }

    // Si no hay errores → éxito
    if (empty($errores)) {
        $mensaje_exito = "Formulario enviado correctamente. Gracias por inscribirte, $nombre.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Clases</title>
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
            <a href="../Clases/clases.php" class="activo">Clases</a>
            <a href="../Información/informacion.html">Información</a>
            <a href="../Login/login.php">Inicio de sesión</a>
        </div>
    </div>

    <div id="recuadro">
        <div id="clases">
            <h1 class="pa">Clases de Padel</h1>
            <p>En PadelOrgaz ofrecemos clases de pádel para todos los niveles...</p>

            <h2 class="pa">Niveles de Clases</h2>
            <ul>
                <li><strong>Principiantes:</strong> Aprende los fundamentos...</li>
                <li><strong>Intermedios:</strong> Mejora tus habilidades...</li>
                <li><strong>Avanzados:</strong> Perfecciona tu juego...</li>
                <li><strong>Menores:</strong> Clases para niños y adolescentes...</li>
            </ul>

            <h2 class="pa">Horarios y Precios</h2>
            <p>⏰ Clases en horarios flexibles...</p>

            <h2 class="pa">Inscripción</h2>
            <p>Rellena el siguiente formulario para reservar tu primera clase.</p>
        </div>

        <div id="formclases">
            <h3>Formulario de inscripción para Clases de Padel</h3>

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
                    <label for="correo"><div class="asterisco">*</div> Correo electrónico:</label>
                    <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>">
                </div>

                <div class="fila-mensaje">
                    <label for="mensaje"><div class="asterisco">*</div> Datos de interés:</label>
                    <textarea id="mensaje" name="mensaje"><?= htmlspecialchars($mensaje) ?></textarea>
                </div>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

</body>
</html>
