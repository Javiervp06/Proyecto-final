<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login/login.php?error=acceso_denegado");
    exit();
}
require_once "../bdd/config.php";

// Obtenemos los datos del administrador actual 
$id_admin = $_SESSION['usuario_id'];
$sql_admin = "SELECT nombre, apellidos, avatar FROM usuarios WHERE id = ?"; // Añadido 'apellidos'
$stmt_admin = $conexion->prepare($sql_admin);
$stmt_admin->bind_param("i", $id_admin);
$stmt_admin->execute();
$datos_admin = $stmt_admin->get_result()->fetch_assoc();

$ruta_avatar = ($datos_admin['avatar']) ? "../uploads/" . $datos_admin['avatar'] : "../Imágenes/default-avatar.jpg";

$nombre_completo_admin = $datos_admin['nombre'] . " " . $datos_admin['apellidos'];

// Obtenemos todos los usuarios ordenados por nivel (para ver quién va primero en el ranking)
$sql = "SELECT id, nombre, apellidos, alias, email, nivel, posicion, avatar, creado_en 
        FROM usuarios 
        ORDER BY nivel DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Jugadores - PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
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
            <a href="admin_jugadores.php" class="activo">👥 Jugadores / Ranking</a>
            <a href="admin_mensajes.php">📩 Clases y Contacto</a>
            <a href="admin_profesores.php" class="btn-volver">👨‍🏫 Gestionar Profesores</a>
            <div class="spacer"></div>
            <a href="../Login/cierre_sesion.php" class="logout">🚪 Cerrar Sesión</a>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-header">
            <h2>Gestión de Jugadores</h2>
             <div class="admin-perfil">
                    <span><?= htmlspecialchars($nombre_completo_admin) ?></span>
                    <img src="<?= $ruta_avatar ?>" onerror="this.src='../Imágenes/default-avatar.jpg'" alt="Perfil Admin">
            </div>
        </div>

        <div class="admin-content">
            <div class="admin-panel-box">
                <h3>Ranking y Control de Usuarios</h3>
                <p>Modifica el nivel de los jugadores manualmente o elimina cuentas si es necesario.</p>

                <table class="admin-table" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th>Pos.</th>
                            <th>Jugador</th>
                            <th>Contacto</th>
                            <th>Nivel Actual</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $pos = 1;
                        while($user = $resultado->fetch_assoc()): 
                            // Ruta de la imagen
                            $img = $user['avatar'] ? "../uploads/".$user['avatar'] : "../Imágenes/default-avatar.jpg";
                        ?>
                        <tr>
                            <td><b>#<?= $pos ?></b></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <img src="<?= $img ?>" onerror="this.src='../Imágenes/default-avatar.jpg'" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border: 2px solid #e2e8f0;">
                                    <div>
                                        <strong style="color: #1e293b;"><?= $user['nombre'] ?> <?= $user['apellidos'] ?></strong><br>
                                        <span style="color:#64748b; font-size:12px;">@<?= $user['alias'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td><span style="font-size:13px; color:#64748b;"><?= $user['email'] ?></span></td>
                            
                            <td>
                                <form action="admin_actualizar_nivel.php" method="POST" style="display:flex; gap:8px; align-items:center; margin:0;">
                                    <input type="hidden" name="id_usuario" value="<?= $user['id'] ?>">
                                    <input type="number" step="0.01" name="nuevo_nivel" value="<?= number_format($user['nivel'], 2) ?>" style="width:75px; padding:6px; border:1px solid #cbd5e1; border-radius:6px; font-family: Montserrat;">
                                    <button type="submit" style="background:#0A58CA; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-weight: 600; font-size: 12px; transition: 0.3s;">Guardar</button>
                                </form>
                            </td>

                            <td><span style="font-size:13px; color:#64748b;"><?= date("d/m/Y", strtotime($user['creado_en'])) ?></span></td>
                            
                            <td>
                                <form action="admin_eliminar_usuario.php" method="POST" style="margin:0;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este jugador? Se perderá todo su historial.');">
                                    <input type="hidden" name="id_usuario" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn-delete">Expulsar</button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                        $pos++;
                        endwhile; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>