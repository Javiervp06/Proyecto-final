<?php
session_start();

// Proteger la página: solo usuarios logueados
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../bdd/config.php";

// Obtener datos del usuario
$id = $_SESSION["usuario_id"];
$sql = "SELECT * FROM usuarios WHERE id = $id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    $nombre = $usuario["nombre"];
    $alias = $usuario["alias"];
    $email = $usuario["email"];
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

        <!-- FIX PARA QUE EL FOOTER BAJE COMO EN EL RANKING -->
        <div id="panel-libre">

            <style>
                /* FIX: anula el min-height del recuadro SOLO dentro del panel */
                #panel-libre {
                    min-height: auto !important;
                    height: auto !important;
                    display: block !important;
                    width: 100%;
                }

                /* PANEL GENERAL */
                #panel-jugador {
                    width: 95%;
                    margin: 20px auto;
                }

                #panel-jugador h1 {
                    text-align: center;
                    margin-bottom: 25px;
                    font-size: 32px;
                    color: #1a3d7c;
                }

                /* CONTENEDOR DOS COLUMNAS */
                .panel-contenedor {
                    display: flex !important;
                    align-items: flex-start !important;
                    justify-content: space-between;
                    gap: 20px;
                    width: 100%;
                }

                /* IZQUIERDA */
                .panel-izquierda {
                    width: 65%;
                    display: flex;
                    flex-direction: column;
                    gap: 20px;
                }

                /* DERECHA */
                .panel-derecha {
                    width: 35%;
                }

                /* TARJETAS */
                .panel-box {
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                }

                .panel-box h3 {
                    margin: 0 0 10px 0;
                    font-size: 20px;
                }

                .panel-box p {
                    margin: 5px 0;
                }

                .descripcion {
                    color: #444;
                }

                .vacio {
                    font-style: italic;
                    color: #777;
                }

                .boton-editar {
                    display: inline-block;
                    margin-top: 15px;
                    padding: 10px 15px;
                    background-color: #1a3d7c;
                    color: white;
                    text-decoration: none;
                    border-radius: 6px;
                    font-weight: bold;
                }

                .boton-editar:hover {
                    background-color: #16346a;
                }
            </style>

            <div id="panel-jugador">

                <h1>Mi Panel de Jugador</h1>

                <div class="panel-contenedor">

                    <!-- COLUMNA IZQUIERDA -->
                    <div class="panel-izquierda">

                        <div class="panel-box">
                            <h3>✔ Mis Partidas Confirmadas</h3>
                            <p class="descripcion">Estas son tus inscripciones a próximas partidas confirmadas. ¡Todo está listo!</p>
                            <p class="vacio">No hay partidas</p>
                        </div>

                        <div class="panel-box">
                            <h3>🕒 Partidas por Completar</h3>
                            <p class="descripcion">Te avisaremos por email cuando se completen.</p>
                            <p class="vacio">No hay partidas</p>
                        </div>

                        <div class="panel-box">
                            <h3>💤 Partidas en Espera</h3>
                            <p class="descripcion">Si fueras confirmado, te avisaremos por email.</p>
                            <p class="vacio">No hay partidas</p>
                        </div>

                        <div class="panel-box">
                            <h3>🏅 Resultados Pendientes</h3>
                            <p class="descripcion">Marca a los ganadores del partido.</p>
                            <p class="vacio">No hay partidas</p>
                        </div>

                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="panel-derecha">
                        <div class="panel-box">
                            <h3>📊 Mis Estadísticas</h3>

                            <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
                            <p><strong>Alias:</strong> <?= htmlspecialchars($alias) ?></p>
                            <p><strong>Correo:</strong> <?= htmlspecialchars($email) ?></p>
                            <p><strong>Nivel Actual:</strong> 1.00</p>
                            <p><strong>Fecha de Alta:</strong> <?= $usuario["creado_en"] ?></p>
                            <p><strong>¿Socio?:</strong> No</p>
                            <p><strong>Partidos Amistosos:</strong> 0</p>
                            <p><strong>Partidas Competitivas:</strong> 0</p>
                            <hr>
                            <p class="descripcion">Aquí puedes ver tus estadísticas básicas. ¡Sigue jugando para mejorar tu nivel!</p>
                            <a href="editar_perfil.php" class="boton-editar">✏️ Editar perfil</a>

                        </div>
                    </div>

                </div>
            </div>

        </div> <!-- cierre panel-libre -->

    </div> <!-- cierre recuadro -->

    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

</body>

</html>