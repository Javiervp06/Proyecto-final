<?php
session_start();
require_once "../bdd/config.php";

// Obtener todos los jugadores y la fecha de su último partido finalizado
$sql = "SELECT u.id, u.nombre, u.apellidos, u.alias, u.sexo, u.posicion, u.nivel, u.avatar, u.creado_en,
        (SELECT MAX(r.dia) 
         FROM reservas r 
         WHERE r.id_usuario = u.id 
         AND r.dia < CURDATE()) as ultimo_partido
        FROM usuarios u
        ORDER BY u.nivel DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Jugadores</title>
    <link rel="stylesheet" href="../css/inicio.css">

    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <style>
        .capitalizar {
            text-transform: capitalize;
        }
    </style>
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

    <div id="recuadroranking">
        <h3 id="h3reserva">Ranking de jugadores</h3>

        <div class="contenedor-jugadores">

            <?php
            $posicion = 1;

            while ($jug = $resultado->fetch_assoc()):
                $avatar = $jug["avatar"]
                    ? "../uploads/" . $jug["avatar"]
                    : "../Imágenes/default-avatar.jpg";
            ?>

                <div class="jugador-card">

                    <!-- POSICIÓN a la izquierda de la foto -->
                    <div class="jugador-posicion-box">
                        <?= $posicion ?>º
                    </div>

                    <!-- FOTO -->
                    <div class="jugador-imagen">
                        <img src="<?= $avatar ?>" alt="avatar">
                    </div>

                    <!-- NIVEL a la derecha de la foto -->
                    <div class="jugador-nivel-box">
                        <?= number_format($jug["nivel"], 2) ?>
                    </div>

                    <!-- INFORMACIÓN -->
                    <div class="jugador-info">
                        <div class="info-izquierda">
                            <div class="jugador-nombre"><?= htmlspecialchars($jug["alias"]) ?></div>
                            
                            <p>Posición: <span class="capitalizar"><?= htmlspecialchars($jug["posicion"]) ?></span></p>
                            <p class="capitalizar"><?= htmlspecialchars($jug["sexo"]) ?></p>
                            
                            <p>Alta: <?= date("d/m/Y", strtotime($jug["creado_en"])) ?></p>
                        </div>

                        <div class="info-derecha">
                            <p>Último Partido:</p>
                            <b>
                                <?php 
                                if (!empty($jug["ultimo_partido"])) {
                                    echo date("d/m/Y", strtotime($jug["ultimo_partido"]));
                                } else {
                                    echo "Sin partidos";
                                }
                                ?>
                            </b>
                        </div>
                    </div>

                </div>

            <?php
                $posicion++;
            endwhile;
            ?>

        </div>
    </div>

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

</body>

</html>