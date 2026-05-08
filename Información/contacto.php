<?php
session_start();
require_once "../bdd/config.php";

// Lógica de auto-relleno
$nombre_pre = "";
$email_pre = "";
$tel_pre = "";

if (isset($_SESSION["usuario_id"])) {
    $user_id = $_SESSION["usuario_id"];
    $sql_u = "SELECT nombre, email, telefono FROM usuarios WHERE id = $user_id";
    $res_u = $conexion->query($sql_u);
    if ($res_u && $res_u->num_rows === 1) {
        $datos = $res_u->fetch_assoc();
        $nombre_pre = $datos['nombre'];
        $email_pre = $datos['email'];
        $tel_pre = $datos['telefono'];
    }
}
// Procesar solo si se envió el formulario por AJAX
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ajax"])) {
    header('Content-Type: application/json');
    
    // 1. INCLUIR CONEXIÓN A LA BASE DE DATOS
    require_once "../bdd/config.php"; 

    $nombre = trim($_POST["nombre"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $asunto = trim($_POST["asunto"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $mensaje = trim($_POST["mensaje"] ?? "");
    $errores = [];

    if ($nombre === "") $errores[] = "El nombre es obligatorio.";
    if (!preg_match("/^[0-9]{9}$/", $telefono)) $errores[] = "El teléfono debe tener 9 números.";
    if ($asunto === "") $errores[] = "El asunto es obligatorio.";
    elseif (!preg_match("/^(?=.*[a-zA-ZáéíóúÁÉÍÓÚñÑ])[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]+$/u", $asunto)) {
        $errores[] = "El asunto debe contener letras.";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "El correo electrónico no es válido.";
    if ($mensaje === "") $errores[] = "El mensaje es obligatorio.";

    if (empty($errores)) {
        
        // 2. UNIMOS EL ASUNTO AL MENSAJE (Para que lo leas bien en tu panel)
        $mensaje_completo = "ASUNTO: " . $asunto . "\n-------------------\n" . $mensaje;

       // 3. GUARDAMOS EN LA TABLA "CONTACTO"
        $sql = "INSERT INTO contacto (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssss", $nombre, $correo, $telefono, $mensaje_completo);
            
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "mensaje" => "Mensaje enviado correctamente. Gracias por contactarnos, $nombre."]);
            } else {
                echo json_encode(["status" => "error", "errores" => ["Error interno al guardar: " . $conexion->error]]);
            }
        } else {
            echo json_encode(["status" => "error", "errores" => ["Error de conexión con la base de datos."]]);
        }
        
    } else {
        echo json_encode(["status" => "error", "errores" => $errores]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Contacto</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
</head>
<body>
    <header class="header-universal">
        <div class="header-container">
            <div class="header-logo">
                <a href="../Pantalla_inicio/inicio.php">
                    <img src="../Imágenes/Logopaginaweb.png" alt="PadelOrgaz Logo">
                </a>
            </div>

            <div class="header-info">
                <div class="info-block">
                    <span class="info-icon">📍</span>
                    <div class="info-texts">
                        <p class="info-title">Ubicación</p>
                        <p class="info-sub">C. la Trancha, 0, Torreorgaz</p>
                    </div>
                </div>
                
                <div class="info-divider"></div>

                <div class="info-block">
                    <span class="info-icon">📞</span>
                    <div class="info-texts">
                        <p class="info-title">Contacto</p>
                        <p class="info-sub">665 33 37 91 | Jvidartep05@educarex.es</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="contenedor"><?php include "../componentes/menu.php"; ?></div>

    <div id="recuadro">
        <div id="recuadroinfo">
            <div id="informacion">
                <p id="parrafito">Acerca de nosotros:</p>
                <a href="informacion.php">1. ¿Dónde estamos?</a><br>
                <a href="normas.php">2. Normas</a><br>
                <a href="anulacion.php">3. Reservas y anulaciones</a><br>
                <a href="tarifas.php">4. Tarifas</a><br>
                <a href="servicios.php">5. Servicios</a><br>
                <a href="contacto.php" class="activo">6. Contacto</a>
            </div>

            <div class="contenido">
                <h2>6. Contacto</h2>
                <p>En este apartado puedes enviarnos tus quejas, reclamaciones, sugerencias o cualquier otro tipo de mensaje.</p>

                <div id="caja-mensajes" style="display: none; padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: bold; text-align: center;"></div>

                <div id="recuadrocontacto">
                    <form id="form-contacto" action="" method="post">
                        <div class="fila">
                            <label for="nombre"><div class="asterisco">*</div> Nombre:</label>
                            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre_pre) ?>">
                        </div>
                        <div class="fila">
                            <label for="telefono"><div class="asterisco">*</div> Teléfono:</label>
                            <input type="text" id="telefono" name="telefono" maxlength="9" pattern="[0-9]{9}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?= htmlspecialchars($tel_pre) ?>">
                        </div>
                        <div class="fila">
                            <label for="asunto"><div class="asterisco">*</div> Asunto:</label>
                            <input type="text" id="asunto" name="asunto">
                        </div>
                        <div class="fila">
                            <label for="correo"><div class="asterisco">*</div> Correo electrónico:</label>
                            <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($email_pre) ?>">
                        </div>
                        <div class="fila-mensaje">
                            <label for="mensaje"><div class="asterisco">*</div> Mensaje:</label>
                            <textarea id="mensaje" name="mensaje"></textarea>
                        </div>
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer><p>© 2025 Padelorgaz.</p></footer>

    <script>
        const formContacto = document.getElementById("form-contacto");
        const cajaMensajes = document.getElementById("caja-mensajes");

        formContacto.addEventListener("submit", function(event) {
            event.preventDefault();
            cajaMensajes.style.display = "none";
            const formData = new FormData(formContacto);
            formData.append("ajax", "1"); // Avisamos al PHP que es AJAX

            fetch("", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                cajaMensajes.style.display = "block";
                if (data.status === "error") {
                    cajaMensajes.style.cssText = "display:block; padding:15px; margin-bottom:20px; border-radius:8px; font-weight:bold; background-color:#fff1f2; color:#e11d48; border:1px solid #e11d48;";
                    cajaMensajes.innerHTML = "<ul style='text-align:left; margin:0;'>" + data.errores.map(e => `<li>${e}</li>`).join("") + "</ul>";
                } else {
                    cajaMensajes.style.cssText = "display:block; padding:15px; margin-bottom:20px; border-radius:8px; font-weight:bold; text-align:center; background-color:#e0f2e9; color:#2e7d32; border:1px solid #2e7d32;";
                    cajaMensajes.innerHTML = "✅ " + data.mensaje;
                    formContacto.reset(); // Vaciamos el formulario
                }
                window.scrollTo({ top: cajaMensajes.offsetTop - 50, behavior: "smooth" });
            });
        });
    </script>
</body>
</html>