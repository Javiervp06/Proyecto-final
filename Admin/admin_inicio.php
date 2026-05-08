<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login/login.php?error=acceso_denegado");
    exit();
}
require_once "../bdd/config.php";

// Consulta para obtener los 5 últimos movimientos globales del sistema
$sql_movimientos = "
    (SELECT 'usuario' as tipo, alias as titulo, creado_en as fecha, NULL as info_extra_1, NULL as info_extra_2, NULL as info_extra_3, NULL as info_extra_4 FROM usuarios)
    UNION
    (SELECT 'reserva' as tipo, CONCAT('Reserva Pista ', r.pista_id) as titulo, r.creado_en as fecha, r.dia as info_extra_1, r.hora_inicio as info_extra_2, u.nombre as info_extra_3, u.alias as info_extra_4 
     FROM reservas r 
     JOIN usuarios u ON r.id_usuario = u.id)
    UNION
    (SELECT 'mensaje' as tipo, nombre as titulo, fecha_solicitud as fecha, NULL as info_extra_1, NULL as info_extra_2, NULL as info_extra_3, NULL as info_extra_4 FROM clases)
    ORDER BY fecha DESC 
    LIMIT 6";

$res_movimientos = $conexion->query($sql_movimientos);

// Obtenemos los datos del administrador actual 
$id_admin = $_SESSION['usuario_id'];
$sql_admin = "SELECT nombre, apellidos, avatar FROM usuarios WHERE id = ?"; // Añadido 'apellidos'
$stmt_admin = $conexion->prepare($sql_admin);
$stmt_admin->bind_param("i", $id_admin);
$stmt_admin->execute();
$datos_admin = $stmt_admin->get_result()->fetch_assoc();

$ruta_avatar = ($datos_admin['avatar']) ? "../uploads/" . $datos_admin['avatar'] : "../Imágenes/default-avatar.jpg";

$nombre_completo_admin = $datos_admin['nombre'] . " " . $datos_admin['apellidos'];
// 1. Reservas para HOY
$hoy = date('Y-m-d');
$sql_reservas = "SELECT SUM(jugadores) as total FROM reservas WHERE dia = '$hoy'";
$res_reservas = $conexion->query($sql_reservas);
$datos_reservas = $res_reservas->fetch_assoc();
$total_hoy = $datos_reservas['total'] ?? 0;

// 2. Jugadores Registrados (Total de usuarios)
$sql_usuarios = "SELECT COUNT(*) as total FROM usuarios";
$res_usuarios = $conexion->query($sql_usuarios);
$datos_usuarios = $res_usuarios->fetch_assoc();
$total_jugadores = $datos_usuarios['total'] ?? 0;

// 3. Mensajes/Inscripciones a clases (Pendientes)
// Nota: Aquí asumo que tienes una tabla llamada 'clases' o 'mensajes'
$sql_mensajes = "SELECT COUNT(*) as total FROM clases"; 
$res_mensajes = $conexion->query($sql_mensajes);
$datos_mensajes = $res_mensajes->fetch_assoc();
$total_mensajes = $datos_mensajes['total'] ?? 0;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css"> 
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
</head>
<body class="admin-body">

    <aside class="admin-sidebar">
        <div class="admin-logo">
            <img src="../Imágenes/Logopaginaweb.png" alt="Logo PadelOrgaz">
            <h2>Admin Panel</h2>
        </div>
        <nav class="admin-menu">
            <a href="admin_inicio.php" class="activo">📊 Dashboard</a>
            <a href="admin_reservas.php">🎾 Gestión de Reservas</a>
            <a href="admin_jugadores.php">👥 Jugadores / Ranking</a>
            <a href="admin_mensajes.php">📩 Clases y Contacto</a>
            <a href="admin_profesores.php" class="btn-volver">👨‍🏫 Gestionar Profesores</a>
            <div class="spacer"></div> <a href="../Login/cierre_sesion.php" class="logout">🚪 Cerrar Sesión</a>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-header">
            <h2><?php echo $nombre_completo_admin; ?></h2>
            
            <div style="display: flex; align-items: center; gap: 20px;">
                <a href="../Pantalla_inicio/inicio.php" target="_blank" 
                style="text-decoration: none; color: #0A58CA; font-weight: 600; font-size: 13px; border: 1px solid #0A58CA; padding: 8px 16px; border-radius: 8px; transition: 0.3s; display: flex; align-items: center; gap: 8px;">
                    🌐 Ver Web Pública
                </a>

                <div class="admin-perfil">
                    <span><?= htmlspecialchars($nombre_completo_admin) ?></span>
                    <img src="<?= $ruta_avatar ?>" onerror="this.src='../Imágenes/default-avatar.jpg'" alt="Perfil Admin">
                </div>
            </div>
        </div>

        <div class="admin-content">
            
            <div class="dashboard-grid">
                <div class="dash-card">
                    <h3>Reservas para Hoy</h3>
                    <p class="big-number"><?php echo $total_hoy; ?></p> 
                </div>
                <div class="dash-card">
                    <h3>Jugadores Registrados</h3>
                    <p class="big-number"><?php echo $total_jugadores; ?></p>
                </div>
                <div class="dash-card">
                    <h3>Solicitudes Clases</h3>
                    <p class="big-number"><?php echo $total_mensajes; ?></p>
                </div>
            </div>

            <div class="admin-panel-box">
                <h3 style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 20px;">🕒</span> Últimos Movimientos
                </h3>
                <ul class="lista-movimientos" style="list-style: none; padding: 0; margin: 0;">
                    <?php while($mov = $res_movimientos->fetch_assoc()): 
                        $icono = "📝"; 
                        $color = "#64748b";
                        $descripcion = "";
                        $detalles_partida = ""; 
                        $enlace = "#"; 

                        if($mov['tipo'] == 'usuario') { 
                            $icono = "👤"; $color = "#0ea5e9"; $descripcion = "Nuevo registro: "; 
                            $enlace = "admin_jugadores.php";
                        } elseif($mov['tipo'] == 'reserva') { 
                            $icono = "🎾"; $color = "#10b981"; $descripcion = "Nueva "; 
                            $enlace = "admin_reservas.php";
                            
                            $dia_juego = date("d/m/Y", strtotime($mov['info_extra_1']));
                            $hora_juego = substr($mov['info_extra_2'], 0, 5);
                            $quien_reserva = htmlspecialchars($mov['info_extra_3']); 
                            $alias_reserva = htmlspecialchars($mov['info_extra_4']); // Recuperamos el alias
                            
                            // Añadimos el nombre Y EL ALIAS del usuario
                            $detalles_partida = "
                                <span style='display: block; font-size: 13px; color: #0A58CA; font-weight: bold; margin-top: 3px;'>
                                    🎾 Juegan el $dia_juego a las {$hora_juego}h
                                </span>
                                <span style='display: block; font-size: 12px; color: #475569; font-style: italic; margin-top: 2px;'>
                                    👤 Por: $quien_reserva <strong style='color:#1e293b;'>($alias_reserva)</strong>
                                </span>";
                            
                        } elseif($mov['tipo'] == 'mensaje') { 
                            $icono = "📩"; $color = "#f59e0b"; $descripcion = "Mensaje de: "; 
                            $enlace = "admin_mensajes.php";
                        }
                    ?>
                        <li style="border-bottom: 1px solid #f1f5f9;">
                            <a href="<?= $enlace ?>" style="display: flex; align-items: center; padding: 12px 10px; text-decoration: none; color: inherit; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                
                                <div style="background: <?= $color ?>20; color: <?= $color ?>; min-width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-right: 15px;">
                                    <?= $icono ?>
                                </div>
                                
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 14px; font-weight: 600; color: #1e293b;">
                                        <?= $descripcion . htmlspecialchars($mov['titulo']) ?>
                                    </span>
                                    
                                    <?= $detalles_partida ?>
                                    
                                    <span style="font-size: 11px; color: #94a3b8; margin-top: 4px;">
                                        Hecho el: <?= date("d/m/Y - H:i", strtotime($mov['fecha'])) ?>
                                    </span>
                                </div>

                                <div style="margin-left: auto; color: #cbd5e1; font-size: 18px;">
                                    ➔
                                </div>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>

        </div>
    </main>

</body>
</html>