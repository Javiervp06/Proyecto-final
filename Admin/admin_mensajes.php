<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login/login.php?error=acceso_denegado");
    exit();
}
require_once "../bdd/config.php";

// Obtenemos los datos del administrador
$id_admin = $_SESSION['usuario_id'];
$sql_admin = "SELECT nombre, apellidos, avatar FROM usuarios WHERE id = ?";
$stmt_admin = $conexion->prepare($sql_admin);
$stmt_admin->bind_param("i", $id_admin);
$stmt_admin->execute();
$datos_admin = $stmt_admin->get_result()->fetch_assoc();

$ruta_avatar = ($datos_admin['avatar']) ? "../uploads/" . $datos_admin['avatar'] : "../Imágenes/default-avatar.jpg";
$nombre_completo_admin = $datos_admin['nombre'] . " " . $datos_admin['apellidos'];

// --- LÓGICA DE PESTAÑAS ---
// Comprobamos qué pestaña quiere ver el admin (por defecto 'pendientes')
$vista = isset($_GET['ver']) ? $_GET['ver'] : 'pendientes';
$estado_buscado = ($vista === 'resueltos') ? 'resuelto' : 'pendiente';

// Obtenemos los mensajes filtrando por el estado
$sql = "SELECT id, nombre, email, telefono, mensaje, fecha_solicitud, estado 
        FROM clases 
        WHERE estado = '$estado_buscado'
        ORDER BY fecha_solicitud DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes y Clases - PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <style>
        .mensaje-box { background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 13px; color: #475569; max-width: 400px; line-height: 1.5; }
        
        /* Botones de acción */
        .btn-success { background: #dcfce7 !important; color: #166534 !important; border: none !important; padding: 6px 12px !important; border-radius: 6px !important; font-weight: 600 !important; cursor: pointer !important; transition: 0.3s; }
        .btn-success:hover { background: #166534 !important; color: white !important; }
        
        .btn-danger { background: #fee2e2 !important; color: #991b1b !important; border: none !important; padding: 6px 12px !important; border-radius: 6px !important; font-weight: 600 !important; cursor: pointer !important; transition: 0.3s; }
        .btn-danger:hover { background: #991b1b !important; color: white !important; }

        /* Estilos para las Pestañas */
        .tabs-container { margin-bottom: 25px; display: flex; gap: 15px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; }
        .btn-tab { padding: 10px 20px; text-decoration: none; color: #64748b; background: #f1f5f9; border-radius: 8px; font-weight: bold; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-tab:hover { background: #e2e8f0; }
        .btn-tab.activo { background: #0A58CA; color: white; }
    </style>
</head>
<body class="admin-body">

    <aside class="admin-sidebar">
        <div class="admin-logo">
            <img src="../Imágenes/Logopaginaweb.png" alt="Logo">
            <h2>Admin Panel</h2>
        </div>
        <nav class="admin-menu">
            <a href="admin_inicio.php">📊 Dashboard</a>
            <a href="admin_reservas.php">🎾 Gestión de Reservas</a>
            <a href="admin_jugadores.php">👥 Jugadores / Ranking</a>
            <a href="admin_mensajes.php" class="activo">📩 Clases y Contacto</a>
            <a href="admin_profesores.php" class="btn-volver">👨‍🏫 Gestionar Profesores</a>
            <div class="spacer"></div>
            <a href="../Login/cierre_sesion.php" class="logout">🚪 Cerrar Sesión</a>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-header">
            <h2>Clases y Contacto</h2>
            <div class="admin-perfil">
                    <span><?= htmlspecialchars($nombre_completo_admin) ?></span>
                    <img src="<?= $ruta_avatar ?>" onerror="this.src='../Imágenes/default-avatar.jpg'" alt="Perfil Admin">
            </div>
        </div>

        <div class="admin-content">
            <div class="admin-panel-box">
                
                <div class="tabs-container">
                    <a href="?ver=pendientes" class="btn-tab <?= $vista == 'pendientes' ? 'activo' : '' ?>">
                        📬 Bandeja de Entrada
                    </a>
                    <a href="?ver=resueltos" class="btn-tab <?= $vista == 'resueltos' ? 'activo' : '' ?>">
                        🗄️ Archivo (Resueltos)
                    </a>
                </div>

                <p>
                    <?= $vista == 'pendientes' ? 'Solicitudes pendientes de revisar y contestar.' : 'Historial de mensajes que ya has gestionado.' ?>
                </p>

                <table class="admin-table" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Contacto</th>
                            <th>Mensaje</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($resultado->num_rows > 0): ?>
                            <?php while($msg = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <b><?= date("d/m/Y", strtotime($msg['fecha_solicitud'])) ?></b><br>
                                    <span style="font-size:12px; color:#64748b;"><?= date("H:i", strtotime($msg['fecha_solicitud'])) ?>h</span>
                                </td>
                                <td><strong style="color: #1e293b;"><?= htmlspecialchars($msg['nombre']) ?></strong></td>
                                <td>
                                    <span style="font-size:13px; color:#64748b;">📧 <?= htmlspecialchars($msg['email']) ?></span><br>
                                    <span style="font-size:13px; color:#64748b;">📞 <?= htmlspecialchars($msg['telefono']) ?: 'No indicado' ?></span>
                                </td>
                                <td>
                                    <div class="mensaje-box">
                                        <?= nl2br(htmlspecialchars($msg['mensaje'])) ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($vista == 'pendientes'): ?>
                                        <form action="admin_resolver_mensaje.php" method="POST" style="margin:0;">
                                            <input type="hidden" name="id_mensaje" value="<?= $msg['id'] ?>">
                                            <button type="submit" class="btn-success">✔️ Marcar Resuelto</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="admin_eliminar_mensaje.php" method="POST" style="margin:0;" onsubmit="return confirm('¿Borrar definitivamente este mensaje? No se puede deshacer.');">
                                            <input type="hidden" name="id_mensaje" value="<?= $msg['id'] ?>">
                                            <button type="submit" class="btn-danger">🗑️ Borrar</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center; padding: 30px; color:#64748b;">
                                    <?= $vista == 'pendientes' ? '🎉 ¡Bandeja limpia! No hay mensajes nuevos.' : 'No tienes ningún mensaje archivado.' ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>