<?php
require "../bdd/config.php";

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
    <link rel="stylesheet" href="../css/inicio.css?v=1">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
</head>
<body>
    <header class="header-universal">
        <div class="header-container">
            <div class="header-logo">
                <a href="../Pantalla_inicio/inicio.php">
                    <img src="../Imágenes/Logopaginaweb.png" alt="PadelOrgaz Logo">
                </a>
            </div>

            <div class="header-info">
                <div class="info-block">
                    <span class="info-icon">📍</span>
                    <div class="info-texts">
                        <p class="info-title">Ubicación</p>
                        <p class="info-sub">C. la Trancha, 0, Torreorgaz</p>
                    </div>
                </div>
                
                <div class="info-divider"></div>

                <div class="info-block">
                    <span class="info-icon">📞</span>
                    <div class="info-texts">
                        <p class="info-title">Contacto</p>
                        <p class="info-sub">665 33 37 91 | Jvidartep05@educarex.es</p>
                    </div>
                </div>
            </div>
        </div>
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
                        // 1. Modificamos la consulta para traernos también el alias
                        $sql = "SELECT u.avatar, u.alias, r.jugadores 
                                FROM reservas r
                                JOIN usuarios u ON r.id_usuario = u.id
                                WHERE r.dia = '$dia'
                                AND r.hora_inicio = '$hora'
                                AND r.pista_id = $pista_id";
                        $res = $conexion->query($sql);
                        
                        $jugadores = [];
                        $jugadores_actuales = 0; // Llevamos la cuenta real

                        while ($row = $res->fetch_assoc()) {
                            $plazas = (int)$row['jugadores'];
                            $jugadores_actuales += $plazas;
                            
                            // Metemos la foto y el alias en un mini-array por cada plaza
                            for ($i = 0; $i < $plazas; $i++) {
                                $jugadores[] = [
                                    'avatar' => $row['avatar'],
                                    'alias' => $row['alias']
                                ];
                            }
                        }

                        // 2. Lógica de estados y colores
                        if ($jugadores_actuales >= 4) {
                            $estado = "Ocupada"; $color = "red";
                        } elseif ($jugadores_actuales > 0) {
                            $estado = "Disponible"; $color = "orange";
                        } else {
                            $estado = "Disponible"; $color = "green";
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
                                // Verificamos si hay un jugador en esta plaza
                                if (!empty($jugadores[$i])) {
                                    $ruta_imagen = "../uploads/" . $jugadores[$i]['avatar'];
                                    $alias_jugador = htmlspecialchars($jugadores[$i]['alias']);
                                } else {
                                    $ruta_imagen = "../Imágenes/default-avatar.jpg";
                                    $alias_jugador = "Plaza libre"; // Si no hay nadie, mostramos esto
                                }
                            ?>
                                <div class="jugadorpartida" title="<?= $alias_jugador ?>">
                                    <img src="<?= $ruta_imagen ?>" onerror="this.src='../Imágenes/default-avatar.jpg'" alt="Jugador">
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="estadopista">
                            <span class="tipoestado" style="background-color: <?= $color ?>;">
                                <?= $estado ?> (<?= $jugadores_actuales ?>/4)
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