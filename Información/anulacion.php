<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Anulaciones de reservas</title>
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
                <a href="anulacion.php" class="activo">3. Reservas y anulaciones</a><br>
                <a href="tarifas.php">4. Tarifas</a><br>
                <a href="servicios.php">5. Servicios</a><br>
                <a href="contacto.php">6. Contacto</a>
            </div>
            <div class="contenido">
                <h2>3. Reservas y anulaciones de pista</h2>
                <h3>Reservas de pistas</h3>
                <p>Las reservas de pistas se pueden realizar a través de nuestra página web, 
                    por teléfono llamando al numero que aparece en nuestra cabecera o por correo electrónico. 
                </p>
                <p>
                    Las pistas pueden ser reservadas con hasta 7 días de antelación y el tiempo máximo de reserva es de 1 hora y media por sesión.
                    Dentro de la reserva tenemos varias opciones:
                </p>
                <ul>
                    <li>Podemos reservar una pista completa e invitar a los compañeros con los que desees jugar ese partido.</li>
                    <li>Podemos reservar una pista individualmente o con alguien más y darle la opción a otros jugadores que estén buscando partida de incluirse en la misma.</li>
                    <li>Podemos incluirnos nosotros mismos en una partida que esté buscando jugadores. </li>
                </ul>
                <p>
                    En caso de tener reservada una pista y 24 horas antes del inicio de la partida esté incompleta de jugadores, cualquier otro usuario tendrá derecho
                    de reservar esa misma pista con invitados suyos para reservar ellos la pista completa.
                </p>
                <h3>Anulaciones de reservas</h3>
                <p>Hay varias condiciones para la anulación de reservas:</p>
                    <ul>
                        <li>Las anulaciones deben ser realizadas por el usuario que realizó la reserva.</li>
                        <li>Las anulaciones pueden realizarse a través de nuestra página web, por teléfono o por correo electrónico.</li>
                        <li>En caso de no poder asistir a una reserva realizada, se podrá anular la misma sin penalización alguna si se realiza con al menos 12 horas de antelación.</li>
                        <li> En caso de anular la reserva con menos de 12 horas de antelación, se aplicará una penalización del 50% del coste total de la reserva.</li>
                        <li>Si la anulación se realiza con menos de 2 horas de antelación o en caso de no presentarse a la reserva se aplicará una penalización del 100% del coste total de la reserva.</li>
                    </ul>
                    
                <p class="advertencia">⚠️Nos reservamos el derecho de denegar futuras reservas a usuarios que acumulen un número excesivo de anulaciones o no presentaciones.⚠️</p>
                    
                
        </div>
    </div>
    </div>
    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>
</body>
</html>