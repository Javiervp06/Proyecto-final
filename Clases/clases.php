<?php
session_start();
require_once "../bdd/config.php"; // Necesitamos la conexión

// Inicializamos variables vacías
$nombre_pre = "";
$email_pre = "";
$tel_pre = "";

// Si el usuario está logueado, traemos sus datos
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

$errores = $_SESSION["errores"] ?? [];
$old = $_SESSION["old"] ?? [];
unset($_SESSION["errores"], $_SESSION["old"]);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Clases</title>
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

    <div id="contenedor">
        <?php include "../componentes/menu.php"; ?>
    </div>


    <div id="recuadro">
        <div id="clases">
            <h1 class="pa">Clases de Padel</h1>
            <p>En PadelOrgaz ofrecemos clases de pádel para todos los niveles, desde principiantes hasta jugadores avanzados.</p>

            <h2 class="pa">Niveles de Clases</h2>
            <ul>
                <li><strong>Principiantes:</strong> Aprende los fundamentos del pádel.</li>
                <li><strong>Intermedios:</strong> Mejora tus habilidades con técnicas avanzadas.</li>
                <li><strong>Avanzados:</strong> Perfecciona tu juego con estrategias competitivas.</li>
                <li><strong>Menores:</strong> Clases para niños y adolescentes (máx. 16 años).</li>
            </ul>

            <h2 class="pa">Horarios y Precios</h2>
            <p>⏰ Clases en horarios flexibles, máximo 4 personas por grupo.</p>

            <h2 class="pa">Inscripción</h2>
            <p>Rellena el siguiente formulario para reservar tu primera clase.</p>
        </div>

        <div id="formclases">
            <h3>Formulario de inscripción para Clases de Padel</h3>
            
            <div id="caja-mensajes" style="display: none; padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: bold; text-align: center;"></div>

            <form id="form-clases">
                <div class="fila">
                    <label for="nombre"><div class="asterisco">*</div> Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre_pre) ?>">
                </div>
                <div class="fila">
                    <label for="telefono"><div class="asterisco">*</div> Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" maxlength="9" pattern="[0-9]{9}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?= htmlspecialchars($tel_pre) ?>">
                </div>
                <div class="fila">
                    <label for="correo"><div class="asterisco">*</div> Correo electrónico:</label>
                    <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($email_pre) ?>">
                </div>
                <div class="fila">
                    <label for="mensaje"><div class="asterisco">*</div> Nivel de la clase:</label>
                    <select id="mensaje" name="mensaje" class="mismo-ancho">
                        <option value="" disabled selected>Selecciona el nivel que buscas...</option>
                        <option value="Principiantes">Clases Principiantes</option>
                        <option value="Intermedios">Clases Nivel Medio</option>
                        <option value="Avanzados">Clases Avanzadas / Competición</option>
                        <option value="Menores">Clases Infantiles</option>
                    </select>
                </div>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
    <footer><p>© 2025 Padelorgaz.</p></footer>

    <script>
        const formClases = document.getElementById("form-clases");
        const cajaMensajes = document.getElementById("caja-mensajes");

        formClases.addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(formClases);

            fetch("procesar_clases.php", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                cajaMensajes.style.display = "block";
                if (data.status === "error") {
                    cajaMensajes.style.cssText = "display:block; padding:15px; margin-bottom:20px; border-radius:8px; font-weight:bold; background-color:#fff1f2; color:#e11d48; border:1px solid #e11d48;";
                    cajaMensajes.innerHTML = "<ul style='text-align:left; margin:0;'>" + data.errores.map(e => `<li>${e}</li>`).join("") + "</ul>";
                } else {
                    cajaMensajes.style.cssText = "display:block; padding:15px; margin-bottom:20px; border-radius:8px; font-weight:bold; text-align:center; background-color:#e0f2e9; color:#2e7d32; border:1px solid #2e7d32;";
                    cajaMensajes.innerHTML = "✅ " + data.mensaje;
                    formClases.reset();
                }
            });
        });
    </script>
</body>
</html>