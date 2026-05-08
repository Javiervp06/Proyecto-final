<?php
session_start();
require_once "../bdd/config.php";

$hoy = date("Y-m-d");
$ahora_hora = date("H:i:s");

// 1. Buscamos SOLO las 2 partidas más próximas que no estén completas
$sql_abiertas = "
    SELECT r.dia, r.hora_inicio, r.pista_id, p.nombre as pista,
    (SELECT SUM(jugadores) FROM reservas res WHERE res.dia = r.dia AND res.hora_inicio = r.hora_inicio AND res.pista_id = r.pista_id) as total_jugadores
    FROM reservas r 
    JOIN pistas p ON r.pista_id = p.id 
    WHERE (r.dia > '$hoy' OR (r.dia = '$hoy' AND r.hora_inicio > '$ahora_hora'))
    GROUP BY r.dia, r.hora_inicio, r.pista_id
    HAVING total_jugadores < 4
    ORDER BY r.dia ASC, r.hora_inicio ASC 
    LIMIT 2
";
$res_abiertas = $conexion->query($sql_abiertas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css">
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
    <div id="recuadro">
        <h1>Bienvenidos a PadelOrgaz</h1>
        
        <p>En Padelorgaz, nos apasiona el pádel y estamos comprometidos en ofrecerte la mejor experiencia posible. Ya seas un jugador experimentado o estés comenzando tu aventura en este emocionante deporte, nuestro club es el lugar perfecto para ti.</p>
        
        <p>Nuestras instalaciones de primera clase incluyen pistas de pádel de última generación, vestuarios cómodos y un ambiente acogedor donde podrás disfrutar del juego con amigos y familiares. Además, contamos con entrenadores profesionales que te ayudarán a mejorar tus habilidades y alcanzar tus objetivos deportivos.</p>
        
        <p>Únete a nuestra comunidad de entusiastas del pádel y participa en torneos emocionantes, clases grupales y eventos sociales que harán que cada visita a Padelorgaz sea inolvidable. ¡Te esperamos en las pistas!</p>
        
        <div id="noticias-container" style="margin-top: 40px; border-top: 2px solid #E2E8F0; padding-top: 20px;">
            <h2 style="color: var(--primary-blue); font-size: 24px; text-align: left; margin-bottom: 20px;">Novedades y Próximos Partidos</h2>
            
            <div id="grid-noticias" class="grid-noticias">
                
                <?php if ($res_abiertas && $res_abiertas->num_rows > 0): ?>
                    <?php while ($partida = $res_abiertas->fetch_assoc()): 
                        $faltan = 4 - $partida['total_jugadores'];
                        $dia_formateado = date("d/m/Y", strtotime($partida['dia']));
                        $hora_formateada = substr($partida['hora_inicio'], 0, 5);
                    ?>
                        <div class="tarjeta-noticia">
                            <img src="../Imágenes/pista_card.webp" alt="Partida Abierta">
                            <div class="contenido-noticia">
                                <h4>🎾 ¡Partida Abierta!</h4>
                                <p>Faltan <strong><?= $faltan ?> jugadores</strong> para el <?= $dia_formateado ?> a las <?= $hora_formateada ?>h.</p>
                                <a href="../Reserva/confirmacion1.php?dia=<?= $partida['dia'] ?>&hora=<?= $partida['hora_inicio'] ?>&pista=<?= $partida['pista_id'] ?>" class="btn-leer-mas">Unirme</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="tarjeta-noticia">
                        <img src="../Imágenes/pista_card.webp" alt="Reserva">
                        <div class="contenido-noticia">
                            <h4>🎾 ¡Reserva tu Pista!</h4>
                            <p>No hay partidas a medias ahora mismo. ¡Anímate a ser el primero en abrir una!</p>
                            <a href="../Reserva/reserva.php" class="btn-leer-mas">Ir a Reservas</a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="tarjeta-noticia">
                    <img src="../Imágenes/clases_card.webp" alt="Clases de Padel">
                    <div class="contenido-noticia">
                        <h4>🎓 Escuela de Pádel</h4>
                        <p>¿Quieres mejorar tu técnica? Inscríbete en nuestras clases para todos los niveles.</p>
                        <a href="../Clases/clases.php" class="btn-leer-mas">Ver Clases</a>
                    </div>
                </div>

                <div class="tarjeta-noticia">
                    <img src="../Imágenes/ranking_card.webp" alt="Ranking Jugadores">
                    <div class="contenido-noticia">
                        <h4>🏆 Ranking del Club</h4>
                        <p>Consulta tu posición y compite con otros jugadores para subir de nivel.</p>
                        <a href="../Jugadores/jugadores.php" class="btn-leer-mas">Ver Ranking</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>
</body>
</html>