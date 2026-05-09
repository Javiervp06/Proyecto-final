<?php
session_start();

// 1. Borramos todas las variables de sesión
session_unset();
session_destroy();

// 2. Destruimos la cookie de "Recordarme" si existe
if (isset($_COOKIE['recuerdame_id'])) {
    // Para borrar una cookie, la volvemos a crear pero le ponemos una fecha de caducidad en el pasado (hace 1 hora = -3600 segundos)
    setcookie("recuerdame_id", "", time() - 3600, "/");
}

// 3. Redirigimos al login tranquilamente
header("Location: ../Login/login.php");
exit();
?>