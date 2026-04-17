<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Jugadores</title>
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
        <h3 id="h3reserva">
            Confirmación de Reserva -
            <span class="fechayhora">Fecha y hora de la partida</span>
            - Padelorgaz
        </h3>

        <div id="cuadrarfechas">
            <div class="fecha" id="dia1"><a href="reserva.php">.</a></div>
            <div class="fecha" id="dia2"><a href="dia2.php">.</a></div>
            <div class="fecha" id="dia3"><a href="dia3.php">.</a></div>
            <div class="fecha" id="dia4"><a href="dia4.php">.</a></div>
            <div class="fecha" id="dia5"><a href="dia5.php">.</a></div>

            <div id="infopista">
                <p><b id="nombrePista"></b></p>
                <img src="../Imágenes/" alt="Imagen de la pista">
            </div>

            <div id="infohorario">
                <p><b>Inicio:</b><br>El (dia) a las (hora)</p>
                <div class="finpartida"><b>Fin:</b><br>El (dia) a las (hora)</div>
            </div>

            <div id="infoestados">
                <p><b>Estado:</b>
                <div class="estado">Según como esté</div>
                </p>
                <div class="numjugadores">Jugadores: 0/4</div>
            </div>

            <div id="jugadoresreserva">
                <h3>Jugadores Confirmados</h3>
                <div class="jugadoresconfirmados">
                    <div class="jugadorconfirma"><img
                            src="../Imágenes/default-avatar.jpg"></div>
                    <div class="jugadorconfirma"><img
                            src="../Imágenes/default-avatar.jpg"></div>
                    <div class="jugadorconfirma"><img
                            src="../Imágenes/default-avatar.jpg"></div>
                    <div class="jugadorconfirma"><img
                            src="../Imágenes/default-avatar.jpg"></div>
                </div>
            </div>

            <div id="inscripcion">
                <h3>Inscribirse a partida:</h3>
                <div class="inscripciones">
                    <div class="columna">
                        Tipo y nivel:<br>
                        <select id="nivel">
                            <option value="amistoso libre">Amistoso - Nivel libre</option>
                            <option value="amistoso 0.25">Amistoso - Mi nivel ±0.25</option>
                            <option value="amistoso 0.5">Amistoso - Mi nivel ±0.5</option>
                        </select>
                    </div>

                    <div class="columna">
                        Jugadores a inscribir:<br>
                        <select id="jugadores">
                            <option value="1">1 jugador</option>
                            <option value="2">2 jugadores</option>
                            <option value="3">3 jugadores</option>
                            <option value="4">4 jugadores</option>
                        </select>
                    </div>

                    <div class="columna">
                        <button id="inscribirse">Inscribirse</button>
                        <form action="guardar_reserva.php" method="POST" id="formReserva" style="display:none;">
                            <input type="hidden" name="dia" id="diaInput">
                            <input type="hidden" name="hora" id="horaInput">
                            <input type="hidden" name="hora_fin" id="horaFinInput">
                            <input type="hidden" name="pista" id="pistaInput">
                            <input type="hidden" name="nivel" id="nivelInput">
                            <input type="hidden" name="jugadores" id="jugadoresInput">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>
    <script src="confirmacion.js"></script>
</body>

</html>