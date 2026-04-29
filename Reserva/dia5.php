<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Reservas</title>
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
    <div id="recuadroreserva">
        <h3 id="h3reserva">Pistas y Partidas de Pádel en Torreorgaz</h3>
        <p>Reserva tu pista de pádel de manera fácil y rápida a través de nuestro sistema en línea. Selecciona la fecha
            y hora que prefieras, elige la pista disponible y confirma tu reserva en pocos pasos. ¡Disfruta de tu juego
            sin complicaciones!</p>
        <div id="cuadrarfechas">
            <div class="fecha" id="dia1"><a href="reserva.php">Hoy</a></div>
            <div class="fecha" id="dia2"><a href="dia2.php">Mañana</a></div>
            <div class="fecha" id="dia3"><a href="dia3.php">Sábado 31</a></div>
            <div class="fecha" id="dia4"><a href="dia4.php">Domingo 1</a></div>
            <div class="fecha" id="dia5"><a href="dia5.php" class="activo">Lunes 2</a></div>
            
            
        </div>
    </div>
    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

    <script src="dias.js"></script>

</body>

</html>