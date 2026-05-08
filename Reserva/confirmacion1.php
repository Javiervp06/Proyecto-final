<?php
session_start();

// 1. Si no hay sesión → enviar a login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php?error=debes_iniciar_sesion");
    exit();
}

require "../bdd/config.php";

//Enlace del perfil del usuario
$id_reserva = $_GET['id'] ?? null;

if ($id_reserva) {
    // Aquí haces el SELECT * FROM reservas WHERE id = $id_reserva
    // Para mostrar quién reservó, qué día, etc.
}

// ===============================
// 2. Recibir datos de la reserva
// ===============================
$dia = $_GET['dia'] ?? null;
$hora = $_GET['hora'] ?? null;
$pista_id = $_GET['pista'] ?? null;

if (!$dia || !$hora || !$pista_id) {
    die("Faltan datos de la reserva.");
}

// ===============================
// 3. Formatear fecha en español (SIN ERRORES)
// ===============================
$dia_largo = "Fecha no disponible";
$titulo_fecha = "Día no seleccionado";
$timestamp = false;

if (!empty($dia)) {
    // El @ oculta cualquier queja si el formato es extraño al cargar
    $timestamp = @strtotime($dia); 
    
    if ($timestamp !== false && $timestamp > 0) {
        $dias_semana = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
        $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];

        // Lo convertimos a entero explícitamente para que PHP no se queje
        $indice_dia = (int)date('w', $timestamp);
        $dia_semana = ucfirst($dias_semana[$indice_dia]);
        
        $dia_num    = date('d', $timestamp);
        $indice_mes = (int)date('n', $timestamp) - 1;
        $mes        = $meses[$indice_mes];

        $dia_largo  = "$dia_semana $dia_num de $mes";
        $titulo_fecha = "$dia_semana $dia_num a las " . htmlspecialchars($hora);
    }
}

// ===============================
// 4. Calcular hora fin (+90 min) y control de tiempo
// ===============================
$hora_fin = "00:00";
if (!empty($hora)) {
    $hora_fin = date("H:i", @strtotime($hora . " +90 minutes"));
}

date_default_timezone_set('Europe/Madrid');
$ahora = time();
$fecha_hora_partida = ($timestamp !== false && !empty($hora)) ? @strtotime("$dia $hora") : 0;
$ha_pasado = ($fecha_hora_partida > 0 && $ahora > $fecha_hora_partida);

// ===============================
// 5. Generar los 5 días para la barra
// ===============================
$dias_barra = [];
for ($i = 0; $i < 5; $i++) {
    $dias_barra[] = date('Y-m-d', strtotime("+$i days"));
}

// ===============================
// 6. Obtener datos de la pista y jugadores
// ===============================
$sqlP = "SELECT nombre, imagen FROM pistas WHERE id = $pista_id";
$pista = $conexion->query($sqlP)->fetch_assoc();

// Traemos el nivel del usuario para mostrarlo con el +-
$sqlJ = "SELECT u.avatar, u.nombre, u.nivel as nivel_usuario, r.jugadores, r.nivel as nivel_partida
         FROM reservas r
         JOIN usuarios u ON r.id_usuario = u.id
         WHERE r.dia = '$dia' AND r.hora_inicio = '$hora' AND r.pista_id = $pista_id
         ORDER BY r.id ASC";

$resJ = $conexion->query($sqlJ);
$jugadores = [];
$jugadores_actuales = 0; 
$nivel_establecido = ""; 
$nivel_del_creador = "";

while ($row = $resJ->fetch_assoc()) {
    $num_plazas_reservadas = (int)$row['jugadores'];
    $jugadores_actuales += $num_plazas_reservadas;
    if (empty($nivel_establecido)) {
        $nivel_establecido = $row['nivel_partida'];
        $nivel_del_creador = $row['nivel_usuario'];
    }
    for ($i = 0; $i < $num_plazas_reservadas; $i++) { $jugadores[] = $row; }
}

$texto_estado = ($jugadores_actuales >= 4) ? "4/4 Completa" : "$jugadores_actuales/4 jugadores";
$color_estado = ($jugadores_actuales >= 4) ? "#e11d48" : (($jugadores_actuales == 0) ? "#00a859" : "#ea580c");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PadelOrgaz - Confirmación</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <style>
        /* === 1. ESTILOS DE LOS DÍAS === */
        .fecha { 
            border-radius: 10px; 
            transition: 0.3s; 
            height: auto !important;
            line-height: normal !important;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .fecha:hover { background-color: #ddd; }
        #dias { width: 100%; margin-bottom: 20px; text-align: center; }
        .fecha a { 
            text-decoration: none; 
            color: inherit; 
            display: flex; 
            justify-content: center;
            align-items: center;
            width: 100%; 
            padding: 15px 5px; 
            box-sizing: border-box;
        }

        /* === 2. NUEVO DISEÑO: TARJETAS (Pista, Horario, Estado) === */
        #contenedor-recuadros { padding: 0; }
        
        #cuadrarfechas { 
            display: flex; 
            flex-wrap: nowrap; /* En PC se ven en una sola fila */
            justify-content: space-between; 
            gap: 20px; 
            width: 100%; 
            margin-bottom: 30px;
        }
        
        #infopista, #infohorario, #infoestados { 
            flex: 1; /* Las 3 tarjetas miden lo mismo */
            background-color: #f8fafc; 
            padding: 25px 20px; 
            border-radius: 16px; 
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); 
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }

        /* Títulos de las tarjetas (Subrayado verde PadelOrgaz) */
        #infopista p:first-child b, #infohorario p:first-child b {
            display: block;
            color: #002d57;
            border-bottom: 3px solid #00a859;
            padding-bottom: 10px;
            margin-bottom: 20px;
            width: 100%;
            text-transform: uppercase;
            font-size: 16px;
        }
        #infoestados > p > b {
            display: block;
            color: #002d57;
            border-bottom: 3px solid #00a859;
            padding-bottom: 10px;
            margin-bottom: 20px;
            width: 100%;
            text-transform: uppercase;
            font-size: 16px;
        }

        /* Imagen de la pista arreglada */
        .foto-pista-contenedor { width: 100%; height: 160px; border-radius: 10px; overflow: hidden; margin-top: auto;}
        .foto-pista-img { width: 100%; height: 100%; object-fit: cover; }
        
        /* Textos de Horario */
        #infohorario p { margin-bottom: 15px; }
        #infohorario span { display: block; margin-top: 5px; color: #475569;}

        /* === 3. NUEVO DISEÑO: JUGADORES E INSCRIPCIÓN === */
        #jugadoresreserva, #inscripcion { 
            width: 100%; 
            background-color: #f8fafc; 
            padding: 30px; 
            border-radius: 16px; 
            border: 1px solid #e2e8f0;
            margin-bottom: 25px; 
            box-sizing: border-box; 
            text-align: center;
        }
        
        #jugadoresreserva h3, #inscripcion h3 { color: #002d57; margin-top: 0; margin-bottom: 30px; font-size: 22px;}

        .jugadoresconfirmados { 
            display: flex; 
            justify-content: center; 
            gap: 40px; 
            flex-wrap: wrap;
        }
        
        /* ¡AVATARES CIRCULARES! */
        .jugadorconfirma { 
            width: 100px; 
            height: 100px; 
            border-radius: 50%; 
            overflow: hidden; 
            background: #e2e8f0; 
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .jugadorconfirma img { width: 100%; height: 100%; object-fit: cover; }
        
        /* Botoncito del nivel del jugador */
        .btn-nivel-fijo { 
            padding: 8px 15px; 
            background-color: #eef4ff; 
            border-radius: 20px; 
            font-weight: bold; 
            margin-top: 10px; 
            color: #085fe2; 
            display: inline-block; 
            font-size: 14px;
        }

        /* Responsive: En móvil apilamos las tarjetas */
        @media (max-width: 800px) {
            #cuadrarfechas { flex-direction: column; }
            #infopista, #infohorario, #infoestados { width: 100%; }
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

    <div id="recuadroreserva">
        <h3 id="h3reserva">Confirmación de Reserva - <span class="fechayhora">El <?= $titulo_fecha ?></span></h3>

        <div id="dias">
            <?php foreach ($dias_barra as $d_opcion): 
                $texto_dia = date('d/m', strtotime($d_opcion));
                $estilo = ($d_opcion == $dia) ? 'background-color: #0A58CA; color: white; border-color: #0A58CA;' : '';
            ?>
                <div class="fecha" style="<?= $estilo ?>">
                    <a href="../Reserva/reserva.php?dia=<?= $d_opcion ?>" style="<?= ($d_opcion == $dia) ? 'color: white;' : '' ?>">
                        <?= $texto_dia ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="contenedor-recuadros">
            
            <div id="cuadrarfechas">
                <div id="infopista">
                    <p><b><?= $pista['nombre'] ?></b></p>
                    <div class="foto-pista-contenedor"><img src="../Imágenes/<?= $pista['imagen'] ?>" class="foto-pista-img"></div>
                </div>
                
                <div id="infohorario">
                    <p><b>Inicio:</b> <span>El <?= $dia_largo ?><br>a las <?= $hora ?></span></p>
                    <p><b>Fin:</b> <span>El <?= $dia_largo ?><br>a las <?= $hora_fin ?></span></p>
                </div>
                
                <div id="infoestados">
                    <p><b>Estado:</b></p>
                    <div style="color: <?= $color_estado ?>; font-weight: bold; font-size: 26px; margin-top: 20px;"><?= $texto_estado ?></div>
                </div>
            </div> <div id="jugadoresreserva">
                <h3>Jugadores Confirmados</h3>
                <div class="jugadoresconfirmados">
                    <?php for ($i = 0; $i < 4; $i++): 
                        $img = (isset($jugadores[$i]) && $jugadores[$i]['avatar']) ? "../uploads/".$jugadores[$i]['avatar'] : "../Imágenes/default-avatar.jpg";
                    ?>
                        <div class="jugadorconfirma">
                            <img src="<?= $img ?>" onerror="this.src='../Imágenes/default-avatar.jpg'">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div id="inscripcion">
            <?php if ($ha_pasado): ?>
                <h3 style="text-align: center; color: gray;">Partida finalizada</h3>
            <?php elseif ($jugadores_actuales >= 4): ?>
                <h3 style="text-align: center; color: #e11d48;">Partida completa</h3>
            <?php else: ?>
                <h3>Inscribirse a partida</h3>
                <div class="inscripciones" style="display: flex; gap: 30px; justify-content: center; align-items: flex-end;">
                    <div class="columna" style="text-align: left;">
                        <span style="font-weight: bold; color:#475569;">Tipo y nivel:</span><br>
                        <?php if ($jugadores_actuales == 0): ?>
                            <select id="nivel" style="padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 5px; width: 200px;">
                                <option value="amistoso libre">Amistoso - Nivel libre</option>
                                <option value="amistoso 0.25">Amistoso - Mi nivel ±0.25</option>
                                <option value="amistoso 0.5">Amistoso - Mi nivel ±0.5</option>
                            </select>
                        <?php else: ?>
                            <div class="btn-nivel-fijo">
                                <?php 
                                    if (strpos($nivel_establecido, '0.25') !== false || strpos($nivel_establecido, '0.5') !== false) {
                                        $margen = (strpos($nivel_establecido, '0.25') !== false) ? "0.25" : "0.5";
                                        echo "Nivel " . number_format($nivel_del_creador, 2) . " ± " . $margen;
                                    } else {
                                        echo ucfirst(htmlspecialchars($nivel_establecido));
                                    }
                                ?>
                            </div>
                            <input type="hidden" id="nivel" value="<?= htmlspecialchars($nivel_establecido) ?>">
                        <?php endif; ?>
                    </div>
                    
                    <div class="columna" style="text-align: left;">
                        <span style="font-weight: bold; color:#475569;">Jugadores:</span><br>
                        <select id="jugadores" style="padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 5px; width: 200px;">
                            <option value="1">1 jugador</option>
                            <?php if ($jugadores_actuales <= 2): ?>
                                <option value="2">2 jugadores</option>
                            <?php endif; ?>
                            <?php if ($jugadores_actuales <= 1): ?>
                                <option value="3">3 jugadores</option>
                            <?php endif; ?>
                            <?php if ($jugadores_actuales == 0): ?>
                                <option value="4">4 jugadores (Pista completa)</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="columna">
                        <button id="inscribirse" style="background:#00a859; color:white; border:none; padding:12px 30px; border-radius:8px; cursor:pointer; font-weight: bold; font-size: 15px; box-shadow: 0 4px 10px rgba(0,168,89,0.3);">
                            Inscribirse
                        </button>
                    </div>
                </div>
            <?php endif; ?>
            </div>
            
        </div>
    </div>
    <footer><p>© 2025 Padelorgaz.</p></footer>
    
    <form action="guardareserva.php" method="POST" id="formReserva" style="display:none;">
        <input type="hidden" name="dia" value="<?= $dia ?>">
        <input type="hidden" name="hora" value="<?= $hora ?>">
        <input type="hidden" name="hora_fin" value="<?= date('H:i', strtotime($hora . ' +90 minutes')) ?>">
        <input type="hidden" name="pista" value="<?= $pista_id ?>">
        <input type="hidden" name="nivel" id="nivelInput">
        <input type="hidden" name="jugadores" id="jugadoresInput">
    </form>
    <script src="confirmacion.js"></script>
</body>
</html>