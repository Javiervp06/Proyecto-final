<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login/login.php?error=acceso_denegado");
    exit();
}
require_once "../bdd/config.php";

// Establecemos la zona horaria de España para que la comparación sea exacta
date_default_timezone_set('Europe/Madrid');
$fecha_hoy = date('Y-m-d');
$hora_ahora = date('H:i:s');

// Obtenemos los datos del administrador actual 
$id_admin = $_SESSION['usuario_id'];
$sql_admin = "SELECT nombre, apellidos, avatar FROM usuarios WHERE id = ?"; // Añadido 'apellidos'
$stmt_admin = $conexion->prepare($sql_admin);
$stmt_admin->bind_param("i", $id_admin);
$stmt_admin->execute();
$datos_admin = $stmt_admin->get_result()->fetch_assoc();

$ruta_avatar = ($datos_admin['avatar']) ? "../uploads/" . $datos_admin['avatar'] : "../Imágenes/default-avatar.jpg";

$nombre_completo_admin = $datos_admin['nombre'] . " " . $datos_admin['apellidos'];

// 1. Obtener solo reservas FUTURAS
// Filtramos: (Día sea mayor a hoy) O (Día sea hoy pero la hora de inicio sea mayor o igual a la actual)
$sql = "SELECT r.id as reserva_id, r.dia, r.hora_inicio, r.jugadores, r.nivel, 
               u.nombre, u.alias, u.avatar, 
               p.nombre as pista_nombre
        FROM reservas r
        JOIN usuarios u ON r.id_usuario = u.id
        JOIN pistas p ON r.pista_id = p.id
        WHERE (r.dia > '$fecha_hoy') 
           OR (r.dia = '$fecha_hoy' AND r.hora_inicio >= '$hora_ahora')
        ORDER BY r.dia ASC, r.hora_inicio ASC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Reservas - PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <style>
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        .admin-table th {
            background-color: var(--primary-blue);
            color: white;
            padding: 15px;
            text-align: left;
        }
        .admin-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-info img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }
        .btn-delete {
            background-color: #dc3545 !important;
            padding: 8px 12px !important;
            font-size: 12px !important;
        }
        .tag-nivel {
            background: #eaf1fb;
            color: var(--primary-blue);
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }
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
            <a href="admin_reservas.php" class="activo">🎾 Gestión de Reservas</a>
            <a href="admin_jugadores.php">👥 Jugadores / Ranking</a>
            <a href="admin_mensajes.php">📩 Clases y Contacto</a>
            <a href="admin_profesores.php" class="btn-volver">👨‍🏫 Gestionar Profesores</a>
            <div class="spacer"></div>
            <a href="../Login/cierre_sesion.php" class="logout">🚪 Cerrar Sesión</a>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-header">
            <h2>Gestión de Reservas</h2>
             <div class="admin-perfil">
                    <span><?= htmlspecialchars($nombre_completo_admin) ?></span>
                    <img src="<?= $ruta_avatar ?>" onerror="this.src='../Imágenes/default-avatar.jpg'" alt="Perfil Admin">
            </div>
        </div>

        <div class="admin-content">
            <div class="admin-panel-box">
                <h3>Listado de Reservas Activas</h3>
                <p>Mostrando las partidas pendientes de jugar hoy y en los próximos días.</p>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Pista</th>
                            <th>Usuario (Creador)</th>
                            <th>Plazas</th>
                            <th>Nivel Partida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($res = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <b><?= date("d/m/Y", strtotime($res['dia'])) ?></b><br>
                                <?= substr($res['hora_inicio'], 0, 5) ?>h
                            </td>
                            <td><?= $res['pista_nombre'] ?></td>
                            <td>
                                <div class="user-info">
                                    <?php $img = $res['avatar'] ? "../uploads/".$res['avatar'] : "../Imágenes/default-avatar.jpg"; ?>
                                    <img src="<?= $img ?>" onerror="this.src='../Imágenes/default-avatar.jpg'">
                                    <div>
                                        <strong><?= $res['nombre'] ?></strong><br>
                                        <small>@<?= $res['alias'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= $res['jugadores'] ?>/4</td>
                            <td><span class="tag-nivel"><?= strtoupper($res['nivel']) ?></span></td>
                            <td>
                                <form action="eliminar_reserva.php" method="POST" onsubmit="return confirm('¿Seguro que quieres cancelar esta reserva?');">
                                    <input type="hidden" name="id_reserva" value="<?= $res['reserva_id'] ?>">
                                    <button type="submit" class="btn-delete">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>