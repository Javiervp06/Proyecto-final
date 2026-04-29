<?php
session_start();
$errores = $_SESSION["errores"] ?? [];
$old = $_SESSION["old"] ?? [];
unset($_SESSION["errores"], $_SESSION["old"]); // SOLO borramos errores, no la sesión entera
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
        <?php include "../componentes/menu.php"; ?>
    </div>


    <div id="recuadro">
        <div id="clases">
            <h1 class="pa">Clases de Padel</h1>
            <p>En PadelOrgaz ofrecemos clases de pádel para todos los niveles, desde principiantes hasta jugadores avanzados.</p>

            <h2 class="pa">Niveles de Clases</h2>
            <ul>
                <li><strong>Principiantes:</strong> Aprende los fundamentos del pádel.</li>
                <li><strong>Intermedios:</strong> Mejora tus habilidades con técnicas avanzadas.</li>
                <li><strong>Avanzados:</strong> Perfecciona tu juego con estrategias competitivas.</li>
                <li><strong>Menores:</strong> Clases para niños y adolescentes (máx. 16 años).</li>
            </ul>

            <h2 class="pa">Horarios y Precios</h2>
            <p>⏰ Clases en horarios flexibles, máximo 4 personas por grupo.</p>

            <h2 class="pa">Inscripción</h2>
            <p>Rellena el siguiente formulario para reservar tu primera clase.</p>
        </div>

        <div id="formclases">
            <h3>Formulario de inscripción para Clases de Padel</h3>

            <form action="procesar_clases.php" method="post">

                <!-- NOMBRE -->
                <div class="fila">
                    <label for="nombre">
                        <div class="asterisco">*</div> Nombre:
                    </label>
                    <input type="text" id="nombre" name="nombre" value="<?= $old['nombre'] ?? '' ?>">
                </div>
                <?php if (isset($errores['nombre'])): ?>
                    <p style="color:red;"><?= $errores['nombre'] ?></p>
                <?php endif; ?>

                <!-- TELEFONO -->
                <div class="fila">
                    <label for="telefono">
                        <div class="asterisco">*</div> Teléfono:
                    </label>
                    <input type="number" id="telefono" name="telefono" value="<?= $old['telefono'] ?? '' ?>">
                </div>
                <?php if (isset($errores['telefono'])): ?>
                    <p style="color:red;"><?= $errores['telefono'] ?></p>
                <?php endif; ?>

                <!-- CORREO -->
                <div class="fila">
                    <label for="correo">
                        <div class="asterisco">*</div> Correo electrónico:
                    </label>
                    <input type="email" id="correo" name="correo" value="<?= $old['correo'] ?? '' ?>">
                </div>
                <?php if (isset($errores['correo'])): ?>
                    <p style="color:red;"><?= $errores['correo'] ?></p>
                <?php endif; ?>

                <!-- MENSAJE -->
                <div class="fila-mensaje">
                    <label for="mensaje">
                        <div class="asterisco">*</div> Datos de interés:
                    </label>
                    <textarea id="mensaje" name="mensaje"><?= $old['mensaje'] ?? '' ?></textarea>
                </div>
                <?php if (isset($errores['mensaje'])): ?>
                    <p style="color:red;"><?= $errores['mensaje'] ?></p>
                <?php endif; ?>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

</body>

</html>