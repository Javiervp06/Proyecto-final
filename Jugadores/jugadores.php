<?php
session_start();
require_once "../bdd/config.php";

// Obtener todos los jugadores ordenados por nivel DESC
$sql = "SELECT id, nombre, apellidos, alias, sexo, posicion, nivel, avatar, creado_en
        FROM usuarios
        ORDER BY nivel DESC";
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
</head>

<body>
    <header>
        <img src="../Imágenes/Logopaginaweb.png" alt="Logo de Torreorgaz" class="logo">
        <p>C. la Trancha, 0, 10182 Torreorgaz, Cáceres<br>665 33 37 91
            <img src="../Imágenes/whatsapp.jpg">
            <img src="../Imágenes/telefonos.png">
            <br> Jvidartep05@educarex.es
            <img src="../Imágenes/gmail.png">
        </p>
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
                            <div class="jugador-nombre"><?= $jug["alias"] ?></div>
                            <p>Posición: <?= $jug["posicion"] ?></p>
                            <p><?= $jug["sexo"] ?></p>
                            <p>Alta: <?= $jug["creado_en"] ?></p>
                        </div>

                        <div class="info-derecha">
                            <p>Último Partido:  <!--$ultimoPartido --> </p>
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