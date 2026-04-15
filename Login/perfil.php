<?php
session_start();

// Proteger la página: solo usuarios logueados
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Datos del usuario desde la sesión
$nombre = $_SESSION["usuario_nombre"];
$alias = $_SESSION["usuario_alias"];
$email = ""; // Lo sacaremos de la BD

require_once "../bdd/config.php";

// Obtener email desde la BD
$id = $_SESSION["usuario_id"];
$sql = "SELECT email FROM usuarios WHERE id = $id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();
    $email = $fila["email"];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
</head>

<body>
    <header>
        <img src="../Imágenes/Logopaginaweb.png" alt="Logo de Torreorgaz" class="logo">
        <p>C. la Trancha, 0, 10182 Torreorgaz, Cáceres<br>665 33 37 91 
            <img src="../Imágenes/whatsapp.jpg">
            <img src="../Imágenes/telefonos.png"> 
            <br> Jvidartep05@educarex.es <img src="../Imágenes/gmail.png">
        </p>
    </header>

    <div id="contenedor">
        <div id="menu">
            <a href="../Pantalla_inicio/inicio.html">Inicio</a>
            <a href="../Reserva/reserva.php">Reserva de pistas</a>
            <a href="../Jugadores/jugadores.php">Ranking de jugadores</a>
            <a href="../Clases/clases.php">Clases</a>
            <a href="../Información/informacion.html">Información</a>
            <a href="perfil.php" class="activo">Mi perfil</a>
            <a href="cierre_sesion.php">Cerrar sesión</a>
        </div>
    </div>

    <div id="recuadro">
        <h2>Mi Perfil</h2>

        <div class="login">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
            <p><strong>Alias:</strong> <?= htmlspecialchars($alias) ?></p>
            <p><strong>Correo electrónico:</strong> <?= htmlspecialchars($email) ?></p>

            <br>
            <a href="editar_perfil.php" class="boton">Editar perfil</a>
        </div>
    </div>

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

</body>
</html>
