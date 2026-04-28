<?php
require "../bdd/config.php";
session_start();

// Fecha activa: parámetro URL o hoy
$dia = $_GET['dia'] ?? date('Y-m-d');

// Horas disponibles
$horas = ['09:00','10:30','12:00','13:30','15:00','16:30','18:00','19:30','21:00'];
$pistas = [1 => 'Pista 1', 2 => 'Pista 2'];
?>
<!DOCTYPE html>
<html lang="es">
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
        <p>C. la Trancha, 0, 10182 Torreorgaz, Cáceres<br>665 33 37 91 
            <img src="../Imágenes/whatsapp.jpg">
            <img src="../Imágenes/telefonos.png"><br>
            Jvidartep05@educarex.es <img src="../Imágenes/gmail.png">
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
            <div class="fecha" id="dia1"><a href="reserva.php">.</a></div>
            <div class="fecha" id="dia2"><a href="reserva.php">.</a></div>
            <div class="fecha" id="dia3"><a href="reserva.php">.</a></div>
            <div class="fecha" id="dia4"><a href="reserva.php">.</a></div>
            <div class="fecha" id="dia5"><a href="reserva.php">.</a></div>

            <div id="cuadrarpistas">
                <?php foreach ($pistas as $pista_id => $pista_nombre): ?>
                <div class="pistas">
                    <h2><?= $pista_nombre ?></h2>

                    <?php foreach ($horas as $hora): ?>
                    <?php
                        $sql = "SELECT u.avatar 
                                FROM reservas r
                                JOIN usuarios u ON r.id_usuario = u.id
                                WHERE r.dia = '$dia'
                                AND r.hora_inicio = '$hora'
                                AND r.pista_id = $pista_id";
                        $res = $conexion->query($sql);
                        $jugadores = [];
                        while ($row = $res->fetch_assoc()) {
                            $jugadores[] = $row['avatar'];
                        }
                        $jugadores_actuales = count($jugadores);

                        if ($jugadores_actuales == 0) {
                            $estado = "Disponible"; $color = "green";
                        } elseif ($jugadores_actuales < 4) {
                            $estado = "Disponible"; $color = "orange";
                        } else {
                            $estado = "Ocupada"; $color = "red";
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
                                    <img src="../uploads/<?= $avatar ?>">
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="estadopista">
                            <span class="tipoestado" style="background-color: <?= $color ?>;">
                                <?= $estado ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
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