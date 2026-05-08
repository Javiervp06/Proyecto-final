<?php
session_start();

// Proteger la página
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../bdd/config.php";

$id = $_SESSION["usuario_id"];
$sql = "SELECT * FROM usuarios WHERE id = $id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    $nombre = $usuario["nombre"];
    $alias = $usuario["alias"];
    $email = $usuario["email"];
    $nivel_actual = $usuario["nivel"]; // Sacamos el nivel real
}

// --- CONSULTAS PARA TUS CAJAS ---
$hoy = date("Y-m-d");
$ahora_hora = date("H:i:s"); // Necesitamos la hora exacta para ser precisos

// 1. Partidas Confirmadas (La suma TOTAL de jugadores en esa hora/pista es 4)
$sql_conf = "SELECT r.*, p.nombre as pista 
             FROM reservas r 
             JOIN pistas p ON r.pista_id = p.id 
             WHERE r.id_usuario = $id 
             AND (r.dia > '$hoy' OR (r.dia = '$hoy' AND r.hora_inicio > '$ahora_hora'))
             AND (SELECT SUM(jugadores) FROM reservas WHERE dia = r.dia AND hora_inicio = r.hora_inicio AND pista_id = r.pista_id) >= 4 
             ORDER BY r.dia ASC";
$res_conf = $conexion->query($sql_conf);

// 2. Partidas por Completar (La suma TOTAL es menor que 4)
$sql_abiertas = "SELECT r.*, p.nombre as pista 
                 FROM reservas r 
                 JOIN pistas p ON r.pista_id = p.id 
                 WHERE r.id_usuario = $id 
                 AND (r.dia > '$hoy' OR (r.dia = '$hoy' AND r.hora_inicio > '$ahora_hora'))
                 AND (SELECT SUM(jugadores) FROM reservas WHERE dia = r.dia AND hora_inicio = r.hora_inicio AND pista_id = r.pista_id) < 4 
                 ORDER BY r.dia ASC";
$res_abiertas = $conexion->query($sql_abiertas);

// 3. Resultados Pendientes (Partidas en el pasado que siguen 'pendientes')
$sql_pend = "SELECT r.*, p.nombre as pista 
             FROM reservas r 
             JOIN pistas p ON r.pista_id = p.id 
             WHERE r.id_usuario = $id 
             AND (r.dia < '$hoy' OR (r.dia = '$hoy' AND r.hora_inicio <= '$ahora_hora'))
             AND (r.resultado = 'pendiente' OR r.resultado IS NULL) 
             ORDER BY r.dia DESC";
$res_pend = $conexion->query($sql_pend);

// --- Partidos Jugados (Día anterior O Hoy si ya pasó la hora) ---
$sql_jugados = "SELECT COUNT(*) as total FROM reservas 
                WHERE id_usuario = $id 
                AND (
                    dia < '$hoy' 
                    OR (dia = '$hoy' AND hora_inicio <= '$ahora_hora')
                )";

$res_jugados = $conexion->query($sql_jugados);
$total_jugados = $res_jugados->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <style>
        /* MANTENEMOS TUS ESTILOS ORIGINALES */
        #panel-libre { min-height: auto !important; height: auto !important; display: block !important; width: 100%; }
        #panel-jugador { width: 95%; margin: 20px auto; }
        #panel-jugador h1 { text-align: center; margin-bottom: 25px; font-size: 32px; color: #1a3d7c; }
        .panel-contenedor { display: flex !important; align-items: flex-start !important; justify-content: space-between; gap: 20px; width: 100%; }
        .panel-izquierda { width: 65%; display: flex; flex-direction: column; gap: 20px; }
        .panel-derecha { width: 35%; }
        .panel-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s ease, box-shadow 0.3s ease; position: relative; }
        .panel-izquierda .panel-box:hover { transform: scale(1.03); box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15); z-index: 10; border: 1px solid #1a3d7c; }
        .panel-box h3 { margin: 0 0 10px 0; font-size: 20px; }
        .descripcion { color: #444; font-size: 14px; margin-bottom: 10px; }
        .vacio { font-style: italic; color: #777; }
        .boton-editar { display: inline-block; margin-top: 15px; padding: 10px 15px; background-color: #1a3d7c; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; }
        
        /* ESTILOS PARA LOS BOTONES DE NIVEL BLINDADOS */
        .btn-resultado { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-right: 5px; color: white !important; }
        .ganado { background-color: #28a745 !important; }
        .perdido { background-color: #dc3545 !important; }
        .info-reserva { font-size: 0.9em; border-bottom: 1px solid #eee; padding: 10px 0; display: flex; justify-content: space-between; align-items: center; }
        .info-reserva:last-child { border-bottom: none; }
        .boton-admin-acceso {
            display: inline-block; /* Cambiamos 'block' por 'inline-block' para que no ocupe toda la línea */
            /* Eliminamos el width: 100% */
            margin-top: 15px;
            padding: 10px 15px; /* Mismo relleno que el botón de editar */
            background-color: #1e293b;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 6px; /* Mismos bordes que el botón de editar */
            font-weight: bold;
            font-size: 14px; /* Un poco más pequeño, para que encaje bien */
            transition: background 0.3s ease;
        }

        .boton-admin-acceso:hover {
            background-color: #0A58CA;
            color: white;
        }
        /* Estilo para el enlace que envuelve la partida */
        .enlace-reserva {
            text-decoration: none; /* Quita el subrayado */
            color: inherit;       /* Mantiene tus colores de texto */
            display: block;
            width: 100%;
        }

        .li-reserva {
            list-style: none;
            margin-bottom: 10px;
        }

        .reserva-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Efecto al pasar el ratón (Hover) */
        .enlace-reserva:hover .reserva-item {
            background-color: #f1f5f9; /* Gris muy suave */
            border-color: #002d57;    /* Color azul de tu marca */
            transform: translateY(-2px); /* Eleva un poco la tarjeta */
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .flecha-ir {
            margin-left: auto;
            color: #cbd5e1;
            font-size: 18px;
            transition: transform 0.3s;
        }

        .enlace-reserva:hover .flecha-ir {
            color: #002d57;
            transform: translateX(5px); /* La flechita se mueve a la derecha */
        }
        /* Estilos para la envoltura y el botón de cancelar */
        .reserva-wrapper {
            display: flex;
            gap: 10px;
        }
        .enlace-reserva {
            flex-grow: 1; /* Hace que la tarjeta ocupe todo el espacio sobrante */
            text-decoration: none;
            color: inherit;
        }
        .btn-cancelar {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #f87171;
            padding: 0 20px;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        .btn-cancelar:hover {
            background-color: #dc2626;
            color: white;
            transform: scale(1.05);
        }

        /* =========================================
           DISEÑO RESPONSIVE (MÓVILES Y TABLETS) 
           ========================================= */
        @media screen and (max-width: 900px) {
            /* 1. Pasamos de 2 columnas a 1 columna apilada */
            .panel-contenedor { 
                flex-direction: column !important; 
            }
            
            /* 2. Hacemos que ambas columnas ocupen el 100% de la pantalla */
            .panel-izquierda, .panel-derecha { 
                width: 100% !important; 
            }
            
            /* 3. Ajustamos los márgenes generales para aprovechar la pantalla pequeña */
            #panel-jugador { 
                width: 100%; 
                margin: 10px auto; 
                padding: 0 10px; 
                box-sizing: border-box; 
            }
            
            #panel-jugador h1 { 
                font-size: 26px; /* Hacemos el título principal un pelín más pequeño */
            }

            /* 4. Ajustes para los resultados pendientes (que los botones no se monten) */
            .info-reserva {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .info-reserva form {
                width: 100%;
                display: flex;
            }

            .btn-resultado {
                flex-grow: 1; /* Hacemos que los botones de ganar/perder ocupen la mitad cada uno */
                padding: 10px;
            }

            /* 5. Ajustes para el botón de cancelar (la papelera) en móviles */
            .reserva-wrapper {
                flex-direction: column; /* Ponemos la papelera debajo de la tarjeta */
            }
            
            .btn-cancelar {
                width: 100%;
                padding: 12px 0;
                margin-top: 5px;
                border-radius: 8px;
            }
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
        <div id="menu">
            <a href="../Pantalla_inicio/inicio.php">Inicio</a>
            <a href="../Reserva/reserva.php">Reserva de pistas</a>
            <a href="../Jugadores/jugadores.php">Ranking de jugadores</a>
            <a href="../Clases/clases.php">Clases</a>
            <a href="../Información/informacion.php">Información</a>
            <a href="perfil.php" class="activo">Mi perfil</a>
            <a href="cierre_sesion.php">Cerrar sesión</a>
        </div>
    </div>

    <div id="recuadro">
        <div id="panel-libre">
            <div id="panel-jugador">
                <h1>Mi Panel de Jugador</h1>
                <div class="panel-contenedor">
                    <div class="panel-izquierda">
                        
                        <div class="panel-box">
                            <h3>✔ Mis Partidas Confirmadas</h3>
                            <p class="descripcion">Próximas citas en la pista.</p>
                            <?php if ($res_conf->num_rows > 0): ?>
                                <ul class="lista-reservas" style="padding:0;">
                                    <?php while ($reserva = $res_conf->fetch_assoc()): ?>
                                        <li class="li-reserva">
                                            <div class="reserva-wrapper">
                                                <a href="../Reserva/confirmacion1.php?dia=<?= $reserva['dia'] ?>&hora=<?= $reserva['hora_inicio'] ?>&pista=<?= $reserva['pista_id'] ?>" class="enlace-reserva">
                                                    <div class="reserva-item">
                                                        <span class="icono" style="margin-right: 15px; font-size: 20px;">🎾</span>
                                                        <div class="reserva-info">
                                                            <p style="margin: 0;"><strong>Pista:</strong> <?= htmlspecialchars($reserva["pista"]) ?></p>
                                                            <p style="margin: 5px 0 0;"><strong>Día:</strong> <?= date("d/m/Y", strtotime($reserva["dia"])) ?> | <strong>Hora:</strong> <?= substr($reserva["hora_inicio"], 0, 5) ?>h</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="cancelar_reserva.php?id=<?= $reserva['id'] ?>" class="btn-cancelar" title="Cancelar esta reserva" onclick="return confirm('¿Estás seguro de que quieres cancelar tu plaza en esta partida?');">
                                                    🗑️
                                                </a>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else: ?>
                                <p class="vacio">No hay partidas próximas confirmadas.</p>
                            <?php endif; ?>
                        </div>

                        <div class="panel-box">
                            <h3>🕒 Partidas por Completar</h3>
                            <p class="descripcion">Partidas publicadas donde faltan jugadores.</p>
                            <?php if ($res_abiertas->num_rows > 0): ?>
                                <ul class="lista-reservas" style="padding:0;">
                                    <?php while ($reserva = $res_abiertas->fetch_assoc()): ?>
                                        <li class="li-reserva">
                                            <div class="reserva-wrapper">
                                                <a href="../Reserva/confirmacion1.php?dia=<?= $reserva['dia'] ?>&hora=<?= $reserva['hora_inicio'] ?>&pista=<?= $reserva['pista_id'] ?>" class="enlace-reserva">
                                                    <div class="reserva-item">
                                                        <span class="icono" style="margin-right: 15px; font-size: 20px;">⏳</span>
                                                        <div class="reserva-info">
                                                            <p style="margin: 0;"><strong>Pista:</strong> <?= htmlspecialchars($reserva["pista"]) ?></p>
                                                            <p style="margin: 5px 0 0;"><strong>Día:</strong> <?= date("d/m/Y", strtotime($reserva["dia"])) ?> | <strong>Hora:</strong> <?= substr($reserva["hora_inicio"], 0, 5) ?>h</p>
                                                            <p style="margin: 5px 0 0; color: #ea580c; font-size: 0.85em;">Faltan <?= 4 - $reserva["jugadores"] ?> jugadores</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="cancelar_reserva.php?id=<?= $reserva['id'] ?>" class="btn-cancelar" title="Cancelar esta reserva" onclick="return confirm('¿Estás seguro de que quieres cancelar tu plaza en esta partida?');">
                                                    🗑️
                                                </a>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else: ?>
                                <p class="vacio">No hay partidas abiertas.</p>
                            <?php endif; ?>
                        </div>

                        <div class="panel-box">
                            <h3>🏅 Resultados Pendientes</h3>
                            <p class="descripcion">¿Ganaste o perdiste? Anótalo para actualizar tu nivel.</p>
                            <?php if ($res_pend->num_rows > 0): ?>
                                <?php while($r = $res_pend->fetch_assoc()): ?>
                                    <div class="info-reserva">
                                        <span><?= date("d/m", strtotime($r['dia'])) ?> (<?= $r['pista'] ?>)</span>
                                        <form action="actualizar_nivel.php" method="POST" style="margin:0;">
                                            <input type="hidden" name="reserva_id" value="<?= $r['id'] ?>">
                                            <button type="submit" name="resultado" value="victoria" class="btn-resultado ganado">Ganado</button>
                                            <button type="submit" name="resultado" value="derrota" class="btn-resultado perdido">Perdido</button>
                                        </form>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p class="vacio">No tienes resultados por anotar.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="panel-derecha">
                        <div class="panel-box">
                            <h3>📊 Mis Estadísticas</h3>
                            
                            <div style="background: #f8fafc; padding: 20px; border-radius: 15px; margin-bottom: 25px; text-align: center; border: 1.5px solid #e2e8f0; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                                <span style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 800; letter-spacing: 1.5px; margin-bottom: 5px;">Partidos Jugados</span>
                                <span style="font-size: 42px; font-weight: 900; color: #00a859; line-height: 1;"><?= $total_jugados ?></span>
                                <div style="width: 30px; height: 3px; background: #00a859; margin: 10px auto 0; border-radius: 2px;"></div>
                            </div>

                            <div style="text-align: left; line-height: 1.8;">
                                <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
                                <p><strong>Alias:</strong> <?= htmlspecialchars($alias) ?></p>
                                <p><strong>Correo:</strong> <?= htmlspecialchars($email) ?></p>
                                <p><strong>Nivel Actual:</strong> <span style="color: #00a859; font-weight: bold;"><?= number_format($nivel_actual, 2) ?></span></p>
                                <p><strong>Fecha de Alta:</strong> <?= date("d/m/Y", strtotime($usuario["creado_en"])) ?></p>
                            </div>
                            
                            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
                            
                            <a href="editar_perfil.php" class="boton-editar" style="display: block; text-decoration: none; text-align: center; padding: 10px; background: #002d57; color: white; border-radius: 8px; margin-bottom: 10px;">✏️ Editar perfil</a>

                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                                <a href="../Admin/admin_inicio.php" class="boton-admin-acceso" style="display: block; text-decoration: none; text-align: center; padding: 10px; background: #1e293b; color: white; border-radius: 8px;">
                                    🛠️ Panel de Administración
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer><p>© 2025 Padelorgaz.</p></footer>
</body>
</html>