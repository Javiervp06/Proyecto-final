<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Tarifas</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
</head>
<body>
    <header>
        <img src="../Imágenes/Logopaginaweb.png" alt="Logo de Torreorgaz" class="logo">
        <p>C. la Trancha, 0, 10182 Torreorgaz, Cáceres<br>665 33 37 91 <img src="../Imágenes/whatsapp.jpg">
            <img src="../Imágenes/telefonos.png"> <br> Jvidartep05@educarex.es <img src="../Imágenes/gmail.png">
        </p>
    </header>
    <div id="contenedor">
         <?php include "../componentes/menu.php"; ?>
    </div>
    <div id="recuadro">
        <div id="recuadroinfo">
            <div id="informacion">
                <p id="parrafito">Acerca de nosotros:</p>
                <a href="informacion.php">1. ¿Dónde estamos?</a><br>
                <a href="normas.php">2. Normas</a><br>
                <a href="anulacion.php">3. Reservas y anulaciones</a><br>
                <a href="tarifas.php" class="activo">4. Tarifas</a><br>
                <a href="servicios.php">5. Servicios</a><br>
                <a href="contacto.php">6. Contacto</a>
            </div>
            <div class="contenido">
                <h2>4. Tarifas</h2>
                <p>Tenemos varias tarifas disponibles para adaptarnos a tus necesidades y horarios.</p>
                <p><b>Tarifas entre semana:</b></p>
                <ul>
                    <li>De 8:00 a 14:00 - 10€ por hora</li>
                    <li>De 14:00 a 17:00 - 12€ por hora</li>
                    <li>De 17:00 a 22:00 - 15€ por hora</li>
                </ul>
                <p><b>Tarifas fines de semana y festivos:</b></p>
                <ul>
                    <li>De 8:00 a 14:00 - 12€ por hora</li>
                    <li>De 14:00 a 17:00 - 15€ por hora</li>
                    <li>De 17:00 a 22:00 - 18€ por hora</li>
                </ul>
               
                <p class="advertencia">⚠️ Ofrecemos descuentos especiales para reservas de larga duración y para grupos grandes. Contacta con nosotros para más detalles.</p>
            </div>
        </div>
    </div>
    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>
</body>
</html>