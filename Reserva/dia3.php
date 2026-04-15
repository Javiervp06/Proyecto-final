<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Reservas</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
</head>

<body>
    <header>
        <img src="../Imágenes/Logopaginaweb.png" alt="Logo de Torreorgaz" class="logo">
        <p>C. la Trancha, 0, 10182 Torreorgaz, Cáceres<br>665 33 37 91 <img src="../Imágenes/whatsapp.jpg">
            <img src="../Imágenes/telefonos.png"> <br> Jvidartep05@educarex.es <img src="../Imágenes/gmail.png">
        </p>
    </header>
    <div id="contenedor">
        <?php include "../componentes/menu.php"; ?>

    </div>
    <div id="recuadroreserva">
        <h3 id="h3reserva">Pistas y Partidas de Pádel en Torreorgaz</h3>
        <p>Reserva tu pista de pádel de manera fácil y rápida a través de nuestro sistema en línea. Selecciona la fecha
            y hora que prefieras, elige la pista disponible y confirma tu reserva en pocos pasos. En caso de querer
            reservar
            pista 30 minutos antes o después de las opciones que tenemos deberás llamarnos personalmente. ¡Disfruta de
            tu juego
            sin complicaciones!</p>
        <div id="cuadrarfechas">
            <div class="fecha" id="dia1"><a href="reserva.php"></a></div>
            <div class="fecha" id="dia2"><a href="dia2.php"></a></div>
            <div class="fecha" id="dia3"><a href="dia3.php" class="activo"></a></div>
            <div class="fecha" id="dia4"><a href="dia4.php"></a></div>
            <div class="fecha" id="dia5"><a href="dia5.php"></a></div>
            <div id="cuadrarpistas">
                <div class="pistas">
                    <h2>Pista 1</h2>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="9:00" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">

                        <div class="horas3">
                            <b>9:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                    <div class="infopartida3" data-dia="12/02/2026" data-hora="10:30" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>10:30</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                    <div class="infopartida3" data-dia="12/02/2026" data-hora="12:00" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>12:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                    <div class="infopartida3" data-dia="12/02/2026" data-hora="13:30" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>13:30</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                    <div class="infopartida3" data-dia="12/02/2026" data-hora="15:00" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>15:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                    <div class="infopartida3" data-dia="12/02/2026" data-hora="16:30" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>16:30</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                    <div class="infopartida3" data-dia="12/02/2026" data-hora="18:00" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>18:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                    <div class="infopartida3" data-dia="12/02/2026" data-hora="19:30" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>19:30</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="21:00" data-pista="Pista 1"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>21:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                </div>
                <div class="pistas">
                    <h2>Pista 2</h2>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="9:00" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>9:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="10:30" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>10:30</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="12:00" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>12:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="13:30" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>13:30</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="15:00" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>15:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="16:30" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>16:30</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="18:00" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>18:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="19:30" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>19:30</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>
                    <div class="infopartida3" data-dia="12/02/2026" data-hora="21:00" data-pista="Pista 2"
                        onclick="abrirConfirmacion(this)">


                        <div class="horas3">
                            <b>21:00</b>
                        </div>

                        <div class="jugadorespartida3">
                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 1</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 2</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 3</div>
                            </div>

                            <div class="jugadorpartida3">
                                <img src="../Imágenes/default-avatar-profile-icon-social-media-user-photo-vector.jpg">
                                <div class="jugadoralias3">Alias 4</div>
                            </div>
                        </div>

                        <div class="estadopista3">
                            <span class="tipoestado">Disponible</span>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

    <script src="dias.js"></script>

</body>

</html>