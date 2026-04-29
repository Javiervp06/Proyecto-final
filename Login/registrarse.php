<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Registrarse</title>
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
        <div id="menu">
            <a href="../Pantalla_inicio/inicio.php">Inicio</a>
            <a href="../Reserva/reserva.php">Reserva de pistas</a>
            <a href="../Jugadores/jugadores.php">Ranking de jugadores</a>
            <a href="../Clases/clases.php">Clases</a>
            <a href="../Información/informacion.php">Información</a>
            <a href="../Login/login.php" class="activo">Inicio de sesión</a>
        </div>
    </div>
    <div id="recuadro">
        <h2>Registro de usuario</h2>
        <div id="recuadroregistro">
            <form action="validarregistro.php" method="post">
                <!-- Datos personales -->
                <div class="titulitos">
                    <div class="emoji">💻</div>Datos Personales:
                </div>
                <p>Introduce tus datos personales para completar tu perfil y el alias para mostrarlo a los demás
                    usuarios cuando te inscribas en una partida.</p>
                <div class="alineacion">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" id="Nombre" name="Nombre">
                </div>

                <div class="alineacion">
                    <label for="Apellidos">Apellidos:</label>
                    <input type="text" id="Apellidos" name="Apellidos">
                </div>

                <div class="alineacion">
                    <label for="Telefono">Teléfono:</label>
                    <input type="number" id="Telefono" name="Telefono" min="600000000">
                </div>

                <div class="alineacion">
                    <label for="Alias">Alias:</label>
                    <input type="text" id="Alias" name="Alias">
                </div>
                <hr class="lineas">
                <!-- Acceso -->
                <div class="titulitos">
                    <div class="emoji">🔒</div>Datos de acceso:
                </div>
                <p>Introduce tu email y contraseña para acceder a tu cuenta y poder inscribirte a partidas.</p>
                <div class="alineacion">
                    <label for="new_username">Email:</label>
                    <input type="email" id="new_username" name="new_username">
                </div>

                <div class="alineacion">
                    <label for="confirm_email">Confirmar email:</label>
                    <input type="email" id="confirm_email" name="confirm_email">
                </div>

                <div class="alineacion">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password">
                </div>

                <div class="alineacion">
                    <label for="confirm_password">Confirmar contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
                <hr class="lineas">
                <!-- Juego -->
                <div class="titulitos">
                    <div class="emoji">🥎</div>Datos de juego:
                </div>
                <p>Selecciona tus preferencias de juego y el nivel que consideres que tienes, consulta la guía para
                    orientarte :</p>
                <div class="alineacion">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo">
                        <option value="">--Selecciona uno--</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="alineacion">
                    <label for="posicion">Posición:</label>
                    <select id="posicion" name="posicion">
                        <option value="">--Selecciona uno--</option>
                        <option value="Drive">Drive</option>
                        <option value="Reves">Revés</option>
                        <option value="Ambas">Ambas</option>
                    </select>
                </div>

                <div class="alineacion">
                    <label for="nivel">Nivel de juego:</label>
                    <input type="number" id="nivel" name="nivel" min="1" max="7" step="0.25">
                </div>
                <div id="guia-nivel">
                    <p id="titulo-guia">📘Guía para elegir mi nivel </p>

                    <div id="contenido-guia" class="oculto">
                        <h3>BAJO</h3>
                        <p><strong>NIVEL 1 - 1.25:</strong> <br><br>Acabas de empezar a jugar al pádel.</p>
                        <p><strong>NIVEL 1.5 - 1.75:</strong> <br><br>Experiencia limitada. Sólo intentas mantener las
                            pelotas
                            en juego.</p>
                        <p><strong>NIVEL 2 - 2.25:</strong> <br><br>Tu juego es poco consistente, no sueles usar el
                            revés, no
                            diriges la bola y esta suele ir lenta, no juegas con el rebote de pared, a veces cometes
                            dobles faltas en el saque, casi no subes a la red, tu juego es bastante estático, no te
                            posicionas bien en la pista.</p>
                        <p><strong>NIVEL 2.5 - 2.75:</strong> <br><br>Intentas mantener el juego con tu derecha, te
                            incomoda
                            subir a la red, empiezas a jugar con el rebote de pared pero te resulta complicado, realizas
                            globos intencionados con poca precisión, tu smash no es definitivo, tu posición en la pista
                            sigue sin ser correcta ni dinámica.</p>
                        <p><strong>NIVEL 3 - 3.25:</strong> <br><br>Comienzas a dirigir la bola y a variar tus golpes
                            (liftado,
                            plano, cortado), comienzas a utilizar tu revés, sueles cometer pocas dobles faltas en el
                            saque aunque tu servicio es fácil de restar, tu volea de derecha es consistente, la de revés
                            no tanto, utilizas el rebote de pared correctamente en bolas lentas, tus globos hacen
                            retroceder al oponente.</p>

                        <h3>MEDIO</h3>
                        <p><strong>NIVEL 3.5 - 3.75:</strong> <br><br>Tu juego de derecha es consistente, comienzas a
                            dirigir tu
                            revés y a variar tus golpes, tu saque tiene algo de potencia y empiezas a cortarlo, eres más
                            agresivo en la red y tu volea empieza a ser consistente, comienzas a usar las bajadas de
                            pared, bandejas y golpes de aproximación, te coordinas con tu compañero en pista.</p>
                        <p><strong>NIVEL 4 - 4.25:</strong> <br><br>Tu derecha es fiable e intentas dirigir siempre tus
                            golpes,
                            tu revés es consistente, tu servicio es complicado, tus restos van con control y
                            profundidad, desarrollas voleas bajas, tus bajadas de pared con derecha son potentes y de
                            revés sueles usar globos, defines puntos con tu volea, diriges la bola a la zona débil del
                            oponente, tus bandejas y globos son buenos, juegas en equipo en pista.</p>
                        <p><strong>NIVEL 4.5 - 4.75:</strong> <br><br>Eres ofensivo con tu derecha, golpeas de revés con
                            dirección y potencia en bolas no muy complicadas, tu primer y segunda saque tienen buena
                            potencia, control y dirección, tiene potencia, control y profundidad en las voleas de
                            derecha, consigues golpes definitivos, la sacas por 4, cubres bastante bien la pista y te
                            adaptas al oponente, agresivo en la red y buena anticipación.</p>
                        <p><strong>NIVEL 5 - 5.25:</strong> <br><br>Tu derecha y tu revés son consistentes, fiables y
                            con
                            variedad de golpes, usas la mayoría de tus golpes buscando la debilidad del oponente, tu
                            defensa es buena con bolas rápidas y complicadas, golpeas con fuerza y efectividad, tu
                            bandeja es consistente, usas globos defensivos y ofensivos, tu bajada de pared es buena en
                            casi cualquier situación, la sacas por 3, sabes leer el partido.</p>

                        <h3>ALTO</h3>
                        <p><strong>NIVEL 5.5 - 5.75:</strong> <br><br>Juegas golpes fiables en situaciones
                            comprometidas, has
                            desarrollado una buena anticipación, lees el partido con facilidad buscando los puntos
                            débiles de los rivales, primeros y segundos servicios son golpes profundos y colocados, has
                            desarrollado fuerza y consistencia como mayor arma, varias la estrategia y el estilo de
                            juego en situaciones comprometidas.</p>
                        <p><strong>NIVEL 6 - 6.25:</strong> <br><br>Apareces en rankings de campeonatos, tienes
                            entrenamientos
                            intensivos para torneos regionales y nacionales, y tienes ranking nacional.</p>
                        <p><strong>NIVEL 6.5 - 6.75:</strong> <br><br>Tienes potencial para jugar torneos nacionales de
                            forma
                            continuada.</p>
                        <p><strong>NIVEL 7:</strong> <br><br>Eres jugador profesional de pádel, compites en torneos open
                            y tu
                            mayor fuente de ingresos son los premios de los torneos y sponsors.</p>
                    </div>
                </div>

                <hr class="lineas">
                <!-- Avatar -->
                <div class="titulitos">
                    <div class="emoji">👤</div>Avatar:
                </div>
                <p>Introduce una imagen en formato JPG o PNG para que se muestre en tu perfil (opcional).</p>
                <div class="alineacion">

                    <!-- COLUMNA IZQUIERDA -->
                    <div class="col-izq">
                        <label for="avatar">Imagen:</label>
                        <label for="sustituir">Sustituir:</label>
                    </div>

                    <!-- COLUMNA CENTRAL -->
                    <div class="col-centro">

                        <!-- FILA 1: preview + formato -->
                        <div class="fila-preview">
                            <div id="preview-imagen">
                                <img id="img-preview" src="#" alt="Vista previa de la imagen">
                            </div>

                            <span class="nota">Formato aceptado: JPG o PNG.</span>
                        </div>

                        <!-- FILA 2: input sustituir -->
                        <div class="fila-sustituir">
                            <input type="file" id="sustituir" name="sustituir" accept=".jpg, .jpeg, .png">
                        </div>

                    </div>

                </div>

                <hr class="lineas">
                <button type="submit">Registrarse</button>
            </form>
        </div>

    </div>
    <footer>
        <p>© 2025 Padelorgaz.</p>
    </footer>

    <script>

        const titulo = document.getElementById("titulo-guia");
        const contenido = document.getElementById("contenido-guia");

        titulo.addEventListener("click", () => {
            contenido.classList.toggle("oculto");
        });


        document.getElementById("sustituir").addEventListener("change", function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById("img-preview");

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = "block";
            }
        });
    </script>


</body>

</html>