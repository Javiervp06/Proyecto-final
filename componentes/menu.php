<?php
// Iniciar sesión solo si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detectar la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']);

// Cargar BD
require_once __DIR__ . "/../bdd/config.php";
?>

<div id="menu">

    <!-- INICIO -->
    <a href="../Pantalla_inicio/inicio.php"
        class="<?= $pagina_actual == 'inicio.php' ? 'activo' : '' ?>">
        Inicio
    </a>

    <!-- RESERVA -->
    <a href="../Reserva/reserva.php"
        class="<?= in_array($pagina_actual, ['reserva.php', 'dia2.php', 'dia3.php', 'dia4.php', 'dia5.php', 'confirmacion1.php']) ? 'activo' : '' ?>">
        Reserva de pistas
    </a>


    <!-- JUGADORES -->
    <a href="../Jugadores/jugadores.php"
        class="<?= $pagina_actual == 'jugadores.php' ? 'activo' : '' ?>">
        Ranking de jugadores
    </a>

    <!-- CLASES -->
    <a href="../Clases/clases.php"
        class="<?= $pagina_actual == 'clases.php' ? 'activo' : '' ?>">
        Clases
    </a>

    <!-- INFORMACIÓN -->
    <a href="../Información/informacion.php"
        class="<?= in_array($pagina_actual, [
                    'informacion.php',
                    'anulacion.php',
                    'contacto.php',
                    'normas.php',
                    'servicios.php',
                    'tarifas.php'
                ]) ? 'activo' : '' ?>">
        Información
    </a>


    <?php if (isset($_SESSION["usuario_id"])): ?>

        <?php
        // Obtener avatar del usuario
        $id = $_SESSION["usuario_id"];
        $sql = "SELECT avatar FROM usuarios WHERE id = $id";
        $res = $conexion->query($sql);
        $avatar = "";

        if ($res->num_rows === 1) {
            $avatar = $res->fetch_assoc()["avatar"];
        }

        $ruta_avatar = $avatar ? "../uploads/$avatar" : "../Imágenes/default-avatar.jpg";
        ?>

        <!-- PERFIL -->
        <a href="../Login/perfil.php"
            class="perfil-link <?= $pagina_actual == 'perfil.php' ? 'activo' : '' ?>">
            Mi perfil
        </a>

        <!-- CERRAR SESIÓN -->
        <a href="../Login/cierre_sesion.php">Cerrar sesión</a>

    <?php else: ?>

        <!-- INICIO DE SESIÓN -->
        <a href="../Login/login.php"
            class="<?= $pagina_actual == 'login.php' ? 'activo' : '' ?>">
            Inicio de sesión
        </a>

    <?php endif; ?>
</div>