<?php
session_start();

// 1. Si no hay sesión → enviar a login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php?error=debes_iniciar_sesion");
    exit();
}

require "../bdd/config.php";

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
// 3. Formatear fecha en español
// ===============================
$timestamp = strtotime($dia);

$dias_semana = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
$meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];

$dia_semana = ucfirst($dias_semana[date('w', $timestamp)]);
$dia_num    = date('d', $timestamp);
$mes        = $meses[date('n', $timestamp) - 1];

$dia_largo  = "$dia_semana $dia_num de $mes";
$titulo_fecha = "$dia_semana $dia_num a las $hora";
// ===============================
// 4. Calcular hora fin (+90 min)
// ===============================
$hora_fin = date("H:i", strtotime($hora . " +90 minutes"));

// ===============================
// 5. Obtener datos de la pista
// ===============================
$sqlP = "SELECT nombre, imagen FROM pistas WHERE id = $pista_id";
$resP = $conexion->query($sqlP);
$pista = $resP->fetch_assoc();

if (!$pista) {
    die("No se encontró la pista.");
}

// ===============================
// 6. Obtener jugadores confirmados
// ===============================
$sqlJ = "SELECT u.avatar, u.nombre
         FROM reservas r
         JOIN usuarios u ON r.id_usuario = u.id
         WHERE r.dia = '$dia'
         AND r.hora_inicio = '$hora'
         AND r.pista_id = $pista_id";

$resJ = $conexion->query($sqlJ);

$jugadores = [];
while ($row = $resJ->fetch_assoc()) {
    $jugadores[] = $row;
}

$jugadores_actuales = count($jugadores);

$color_estado = ($jugadores_actuales == 0) ? "green" :
                (($jugadores_actuales <= 3) ? "orange" : "red");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz - Confirmación</title>
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/inicio.css">

<style>

/* DÍAS (NO SE TOCAN) */
.fecha{
    height: 50px;
    background-color: lightgray;
    border-radius: 10px;
    width: 19.5%;
    display: inline-block;
    text-align: center;
    line-height: 50px;
    font-weight: bold;
    cursor: pointer;
}

/* CONTENEDOR DE LOS DÍAS */
#dias{
    width: 100%;
    margin-bottom: 20px;
    text-align: center;
}

/* CONTENEDOR DE LOS RECUADROS */
#contenedor-recuadros{
    padding: 0 20px; /* separación lateral real */
}
#cuadrarfechas{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    gap: 20px;
    width: 100%;
    text-align: left;    /* evita que se vayan a la derecha */
    margin-left: 0;
    margin-right: 0;
}

/* FILA 1: Pista – Inicio – Estado */
#infopista,
#infohorario,
#infoestados {
    width: 31%;
    background-color: rgb(194, 231, 245);
    padding: 10px;
    border-radius: 10px;
    box-sizing: border-box;

    /* MISMA ALTURA PARA LOS 3 */
    height: 300px;
    margin-right:0 !important;
}

/* FOTO DE LA PISTA */
#infopista .foto-pista-contenedor {
    width: 100%;
    height: 200px;        /* altura fija del recuadro */
    border-radius: 10px;
    overflow: hidden;     /* recorta la imagen dentro */
    background: #ddd;     /* color de fondo si tarda en cargar */
}

#infopista .foto-pista-img {
    width: 100%;
    height: 100%;
    object-fit: cover;     /* rellena el recuadro sin deformarse */
    object-position: center; /* centra la imagen */
    display: block;        /* elimina espacios fantasmas */
}


/* FILA 2: Jugadores confirmados */
#jugadoresreserva{
    width: 100%;
    background-color: rgb(194, 231, 245);
    padding: 10px;
    border-radius: 10px;
    box-sizing: border-box;
    margin-bottom:20px;
}
.jugadoresconfirmados{
    display: flex;
    gap: 20px;
    justify-content: flex-start;
}

.jugadorconfirma{
    width: 230px;      /* ← TAMAÑO GRANDE */
    height: 230px;     /* ← TAMAÑO GRANDE */
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.jugadorconfirma img{
    width: 100%;
    height: 100%;
    display: block;
}


/* FILA 3: Inscripción */
#inscripcion{
    width: 100%;
    background-color: rgb(194, 231, 245);
    padding: 10px;
    border-radius: 10px;
    box-sizing: border-box;
    margin-bottom:20px;
}


</style>

</head>

<body>

<header>
    <img src="../Imágenes/Logopaginaweb.png" alt="Logo de Torreorgaz" class="logo">
    <p>C. la Trancha, 0, 10182 Torreorgaz, Cáceres<br>665 33 37 91 
        <img src="../Imágenes/whatsapp.jpg">
        <img src="../Imágenes/telefonos.png"><br>
        Jvidartep05@educarex.es <img src="../Imágenes/gmail.png">
    </p>
</header>

<div id="contenedor">
    <?php include "../componentes/menu.php"; ?>
</div>

<div id="recuadroreserva">

    <h3 id="h3reserva">
        Confirmación de Reserva -
        <span class="fechayhora">El <?= $titulo_fecha ?> en <?= $pista['nombre'] ?></span>
        - Padelorgaz
    </h3>

    <div id="dias">
        <div class="fecha"><a href="reserva.php"></a></div>
        <div class="fecha"><a href="dia2.php"></a></div>
        <div class="fecha"><a href="dia3.php"></a></div>
        <div class="fecha"><a href="dia4.php"></a></div>
        <div class="fecha"><a href="dia5.php"></a></div>
    </div>
    <div id="contenedor-recuadros">
        <div id="cuadrarfechas">

            <div id="infopista">
                <p><b><?= $pista['nombre'] ?></b></p>

                <div class="foto-pista-contenedor">
                    <img src="../Imágenes/<?= $pista['imagen'] ?>" class="foto-pista-img">
                </div>
            </div>

            <div id="infohorario">
                <p><b>Inicio:</b><br>El <?= $dia_largo ?> a las <?= $hora ?></p>
                <div class="finpartida">
                    <b>Fin:</b><br>El <?= $dia_largo ?> a las <?= $hora_fin ?>
                </div>
            </div>

            <div id="infoestados">
                <p><b>Estado:</b></p>
                <div class="estado" style="color: <?= $color_estado ?>;">
                    <?= $jugadores_actuales ?>/4 jugadores
                </div>
            </div>

            <div id="jugadoresreserva">
                <h3>Jugadores Confirmados</h3>

                <div class="jugadoresconfirmados">
                    <?php for ($i = 0; $i < 4; $i++): 
                        $avatar = $jugadores[$i]['avatar'] ?? 'default-avatar.jpg';
                    ?>
                        <div class="jugadorconfirma">
                            <img src="../Imágenes/<?= $avatar ?>">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div id="inscripcion">
                <h3>Inscribirse a partida:</h3>

                <div class="inscripciones">

                    <div class="columna">
                        Tipo y nivel:<br>
                        <select id="nivel">
                            <option value="amistoso libre">Amistoso - Nivel libre</option>
                            <option value="amistoso 0.25">Amistoso - Mi nivel ±0.25</option>
                            <option value="amistoso 0.5">Amistoso - Mi nivel ±0.5</option>
                        </select>
                    </div>

                    <div class="columna">
                        Jugadores a inscribir:<br>
                        <select id="jugadores">
                            <option value="1">1 jugador</option>
                            <option value="2">2 jugadores</option>
                            <option value="3">3 jugadores</option>
                            <option value="4">4 jugadores</option>
                        </select>
                    </div>

                    <div class="columna">
                        <?php if ($jugadores_actuales >= 4): ?>
                            <button id="inscribirse" disabled style="background:red;">Partida completa</button>
                        <?php else: ?>
                            <button id="inscribirse">Inscribirse</button>
                        <?php endif; ?>

                        <form action="guardareserva.php" method="POST" id="formReserva" style="display:none;">
                            <input type="hidden" name="dia" id="diaInput">
                            <input type="hidden" name="hora" id="horaInput">
                            <input type="hidden" name="hora_fin" id="horaFinInput">
                            <input type="hidden" name="pista" id="pistaInput">
                            <input type="hidden" name="nivel" id="nivelInput">
                            <input type="hidden" name="jugadores" id="jugadoresInput">
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<footer>
    <p>© 2025 Padelorgaz.</p>
</footer>

<script src="confirmacion.js"></script>

</body>
</html>
