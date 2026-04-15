<?php
session_start();
require_once "../bdd/config.php";

// Proteger la página
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["usuario_id"];
$errores = [];
$mensaje_exito = "";

// Obtener datos actuales del usuario
$sql = "SELECT * FROM usuarios WHERE id = $id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
} else {
    die("Error al cargar los datos del usuario.");
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recoger datos del formulario (mismos nombres que en registro)
    $nombre = trim($_POST["Nombre"]);
    $apellidos = trim($_POST["Apellidos"]);
    $telefono = trim($_POST["Telefono"]);
    $alias = trim($_POST["Alias"]);
    $email = trim($_POST["new_username"]);
    $confirm_email = trim($_POST["confirm_email"]);
    $sexo = $_POST["sexo"];
    $posicion = $_POST["posicion"];
    $nivel = $_POST["nivel"];

    // Contraseña opcional
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Avatar
    $avatar_actual = $usuario["avatar"];
    $avatar_nuevo = $avatar_actual;

    if (!empty($_FILES["sustituir"]["name"])) {
        $archivo = $_FILES["sustituir"];
        $nombre_archivo = time() . "_" . $archivo["name"];
        $ruta_destino = "../uploads/" . $nombre_archivo;

        if (move_uploaded_file($archivo["tmp_name"], $ruta_destino)) {
            $avatar_nuevo = $nombre_archivo;
        } else {
            $errores[] = "Error al subir la imagen.";
        }
    }

    // Validaciones
    if ($nombre === "") $errores[] = "El nombre es obligatorio.";
    if ($apellidos === "") $errores[] = "Los apellidos son obligatorios.";
    if ($alias === "") $errores[] = "El alias es obligatorio.";

    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    if ($email !== $confirm_email) {
        $errores[] = "Los emails no coinciden.";
    }

    // Contraseña solo si se quiere cambiar
    $actualizar_password = false;

    if ($password !== "" || $confirm_password !== "") {
        if ($password !== $confirm_password) {
            $errores[] = "Las contraseñas no coinciden.";
        } elseif (strlen($password) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres.";
        } else {
            $actualizar_password = true;
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    // Si no hay errores → actualizar
    if (empty($errores)) {

        if ($actualizar_password) {
            $sql_update = "UPDATE usuarios SET 
                nombre='$nombre',
                apellidos='$apellidos',
                telefono='$telefono',
                alias='$alias',
                email='$email',
                sexo='$sexo',
                posicion='$posicion',
                nivel='$nivel',
                avatar='$avatar_nuevo',
                password='$password_hash'
                WHERE id=$id";
        } else {
            $sql_update = "UPDATE usuarios SET 
                nombre='$nombre',
                apellidos='$apellidos',
                telefono='$telefono',
                alias='$alias',
                email='$email',
                sexo='$sexo',
                posicion='$posicion',
                nivel='$nivel',
                avatar='$avatar_nuevo'
                WHERE id=$id";
        }

        if ($conexion->query($sql_update)) {

            // Actualizar sesión
            $_SESSION["usuario_nombre"] = $nombre;
            $_SESSION["usuario_alias"] = $alias;

            $mensaje_exito = "Perfil actualizado correctamente.";

            // Actualizar datos mostrados
            $usuario = array_merge($usuario, [
                "nombre" => $nombre,
                "apellidos" => $apellidos,
                "telefono" => $telefono,
                "alias" => $alias,
                "email" => $email,
                "sexo" => $sexo,
                "posicion" => $posicion,
                "nivel" => $nivel,
                "avatar" => $avatar_nuevo
            ]);
        } else {
            $errores[] = "Error al actualizar el perfil.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Editar Perfil</title>
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
            <a href="../Pantalla_inicio/inicio.html">Inicio</a>
            <a href="../Reserva/reserva.php">Reserva de pistas</a>
            <a href="../Jugadores/jugadores.php">Ranking de jugadores</a>
            <a href="../Clases/clases.php">Clases</a>
            <a href="../Información/informacion.html">Información</a>
            <a href="perfil.php" class="activo">Mi perfil</a>
        </div>
    </div>

    <div id="recuadro">
        <h2>Editar Perfil</h2>

        <?php if (!empty($errores)): ?>
            <div style="color: red;">
                <?php foreach ($errores as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($mensaje_exito): ?>
            <div style="color: green;">
                <p><?= $mensaje_exito ?></p>
            </div>
        <?php endif; ?>

        <div id="recuadroregistro">
            <form action="" method="post" enctype="multipart/form-data">

                <!-- Datos personales -->
                <div class="titulitos">
                    <div class="emoji">💻</div>Datos Personales:
                </div>
                <p>Modifica tus datos personales.</p>

                <div class="alineacion">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" id="Nombre" name="Nombre" value="<?= $usuario['nombre'] ?>">
                </div>

                <div class="alineacion">
                    <label for="Apellidos">Apellidos:</label>
                    <input type="text" id="Apellidos" name="Apellidos" value="<?= $usuario['apellidos'] ?>">
                </div>

                <div class="alineacion">
                    <label for="Telefono">Teléfono:</label>
                    <input type="number" id="Telefono" name="Telefono" min="600000000" value="<?= $usuario['telefono'] ?>">
                </div>

                <div class="alineacion">
                    <label for="Alias">Alias:</label>
                    <input type="text" id="Alias" name="Alias" value="<?= $usuario['alias'] ?>">
                </div>

                <hr class="lineas">

                <!-- Acceso -->
                <div class="titulitos">
                    <div class="emoji">🔒</div>Datos de acceso:
                </div>

                <div class="alineacion">
                    <label for="new_username">Email:</label>
                    <input type="email" id="new_username" name="new_username" value="<?= $usuario['email'] ?>">
                </div>

                <div class="alineacion">
                    <label for="confirm_email">Confirmar email:</label>
                    <input type="email" id="confirm_email" name="confirm_email" value="<?= $usuario['email'] ?>">
                </div>

                <div class="alineacion">
                    <label for="password">Nueva contraseña (opcional):</label>
                    <input type="password" id="password" name="password">
                </div>

                <div class="alineacion">
                    <label for="confirm_password">Confirmar nueva contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>

                <hr class="lineas">

                <!-- Juego -->
                <div class="titulitos">
                    <div class="emoji">🥎</div>Datos de juego:
                </div>

                <div class="alineacion">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo">
                        <option value="">--Selecciona uno--</option>
                        <option value="masculino" <?= $usuario['sexo'] == "masculino" ? "selected" : "" ?>>Masculino</option>
                        <option value="femenino" <?= $usuario['sexo'] == "femenino" ? "selected" : "" ?>>Femenino</option>
                        <option value="otro" <?= $usuario['sexo'] == "otro" ? "selected" : "" ?>>Otro</option>
                    </select>
                </div>

                <div class="alineacion">
                    <label for="posicion">Posición:</label>
                    <select id="posicion" name="posicion">
                        <option value="">--Selecciona uno--</option>
                        <option value="drive" <?= $usuario['posicion'] == "drive" ? "selected" : "" ?>>Drive</option>
                        <option value="reves" <?= $usuario['posicion'] == "reves" ? "selected" : "" ?>>Revés</option>
                        <option value="ambas" <?= $usuario['posicion'] == "ambas" ? "selected" : "" ?>>Ambas</option>
                    </select>
                </div>

                <div class="alineacion">
                    <label for="nivel">Nivel de juego:</label>
                    <input type="number" id="nivel" name="nivel" min="1" max="7" step="0.25" value="<?= $usuario['nivel'] ?>">
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

                    <div class="col-izq">
                        <label>Imagen actual:</label>
                        <label for="sustituir">Sustituir:</label>
                    </div>

                    <div class="col-centro">

                        <div class="fila-preview">
                            <div id="preview-imagen">
                                <img id="img-preview"
                                    src="<?= $usuario['avatar'] ? '../uploads/' . $usuario['avatar'] : '#' ?>"
                                    style="<?= $usuario['avatar'] ? '' : 'display:none;' ?>">
                            </div>

                            <span class="nota">Formato aceptado: JPG o PNG.</span>
                        </div>

                        <div class="fila-sustituir">
                            <input type="file" id="sustituir" name="sustituir" accept=".jpg, .jpeg, .png">
                        </div>

                    </div>

                </div>

                <hr class="lineas">

                <button type="submit">Guardar cambios</button>

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

        document.getElementById("sustituir").addEventListener("change", function(event) {
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