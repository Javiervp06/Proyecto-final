<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-reservas</title>
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
            y hora que prefieras, elige la pista disponible y confirma tu reserva en pocos pasos. En caso de querer
            reservar
            pista 30 minutos antes o después de las opciones que tenemos deberás llamarnos personalmente. ¡Disfruta de
            tu juego
            sin complicaciones! </p>
        <div id="cuadrarfechas">
            <div class="fecha" id="dia1"><a href="reserva.php" class="activo">.</a></div>
            <div class="fecha" id="dia2"><a href="dia2.php">.</a></div>
            <div class="fecha" id="dia3"><a href="dia3.php">.</a></div>
            <div class="fecha" id="dia4"><a href="dia4.php">.</a></div>
            <div class="fecha" id="dia5"><a href="dia5.php">.</a></div>
            <div id="cuadrarpistas">
                <div class="pistas">
    <h2>Pista 1</h2>

    <!-- 09:00 -->
    <?php
        // Datos reales de la celda
        $dia = "2026-02-10";   // ✔ FORMATO CORRECTO
        $hora = "09:00";
        $pista_id = 1;

        // Consulta jugadores apuntados (con avatar)
        $sql = "SELECT u.avatar 
                FROM reservas r
                JOIN usuarios u ON r.id_usuario = u.id
                WHERE r.dia = '$dia'
                AND r.hora_inicio = '$hora'
                AND r.pista_id = $pista_id";

        $res = $conexion->query($sql);

        $jugadores = [];
        while ($row = $res->fetch_assoc()) {
            $jugadores[] = $row['avatar']; // ✔ CAMPO CORRECTO
        }

        $jugadores_actuales = count($jugadores);

        // Estado dinámico
        if ($jugadores_actuales == 0) {
            $estado = "Disponible";
            $color = "green";
        } elseif ($jugadores_actuales < 4) {
            $estado = "Disponible";
            $color = "orange";
        } else {
            $estado = "Ocupada";
            $color = "red";
        }
    ?>

    <div class="infopartida" 
        data-dia="<?= $dia ?>" 
        data-hora="<?= $hora ?>" 
        data-pista="<?= $pista_id ?>" 
        onclick="abrirConfirmacion(this)">

        <div class="horas"><b><?= $hora ?></b></div>

        <div class="jugadorespartida">
            <?php for ($i = 0; $i < 4; $i++): 
                $avatar = $jugadores[$i] ?? 'default-avatar.jpg';
            ?>
                <div class="jugadorpartida">
                    <img src="../uploads/<?= $avatar ?>"> <!-- ✔ RUTA CORRECTA -->
                </div>
            <?php endfor; ?>
        </div>

        <div class="estadopista">
            <span class="tipoestado" style="background-color: <?= $color ?>;">
                <?= $estado ?>
            </span>
        </div>

    </div>





    <!-- 10:30 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="10:30" data-pista="Pista 1" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>10:30</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 12:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="12:00" data-pista="Pista 1" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>12:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 13:30 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="13:30" data-pista="Pista 1" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>13:30</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 15:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="15:00" data-pista="Pista 1" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>15:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 16:30 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="16:30" data-pista="Pista 1" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>16:30</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 18:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="18:00" data-pista="Pista 1" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>18:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 19:30 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="19:30" data-pista="Pista 1" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>19:30</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 21:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="21:00" data-pista="Pista 1" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>21:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

</div>

               <div class="pistas">
    <h2>Pista 2</h2>

    <!-- 09:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="09:00" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>09:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 10:30 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="10:30" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>10:30</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 12:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="12:00" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>12:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 13:30 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="13:30" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>13:30</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 15:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="15:00" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>15:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 16:30 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="16:30" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>16:30</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 18:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="18:00" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>18:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 19:30 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="19:30" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>19:30</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

    <!-- 21:00 -->
    <div class="infopartida" data-dia="10/02/2026" data-hora="21:00" data-pista="Pista 2" onclick="abrirConfirmacion(this)">
        <a href="confirmacion1.php">
            <div class="horas"><b>21:00</b></div>
            <div class="jugadorespartida">
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
                <div class="jugadorpartida"><img src="../Imágenes/default-avatar.jpg"></div>
            </div>
            <div class="estadopista"><span class="tipoestado">Disponible</span></div>
        </a>
    </div>

</div>

            </div>

        </div>
    </div>
    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

    <script src="dias.js"></script>
    <script>
        function abrirConfirmacion(div) {
            const dia = div.dataset.dia;
            const hora = div.dataset.hora;
            const pista = div.dataset.pista;

            window.location.href = `confirmacion1.php?dia=${dia}&hora=${hora}&pista=${pista}`;
        }

    </script>

</body>

</html>