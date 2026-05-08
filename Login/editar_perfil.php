<?php
session_start();
require_once "../bdd/config.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
$id = $_SESSION["usuario_id"];

// 1. PROCESAMIENTO AJAX
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ajax"])) {
    header('Content-Type: application/json');
    $errores = [];
    
    // Obtener datos actuales del usuario para la imagen
    $sql_actual = "SELECT avatar FROM usuarios WHERE id = $id";
    $avatar_actual = $conexion->query($sql_actual)->fetch_assoc()['avatar'];
    $avatar_nuevo = $avatar_actual;

    $nombre = trim($_POST["Nombre"] ?? "");
    $apellidos = trim($_POST["Apellidos"] ?? "");
    $telefono = trim($_POST["Telefono"] ?? "");
    $alias = trim($_POST["Alias"] ?? "");
    $email = trim($_POST["new_username"] ?? "");
    $confirm_email = trim($_POST["confirm_email"] ?? "");
    $sexo = $_POST["sexo"] ?? "";
    $posicion = $_POST["posicion"] ?? "";
    $nivel = $_POST["nivel"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    if (!empty($_FILES["sustituir"]["name"])) {
        $archivo = $_FILES["sustituir"];
        
        // 1. Comprobar si hubo algún error en la subida a nivel de servidor
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $errores[] = "Hubo un error al procesar el archivo.";
        } else {
            // 2. Validar el tamaño máximo (2MB = 2 * 1024 * 1024 bytes)
            $tamano_maximo = 2 * 1024 * 1024;
            if ($archivo['size'] > $tamano_maximo) {
                $errores[] = "La imagen supera el tamaño máximo permitido de 2MB.";
            } else {
                // 3. Validar el MIME type REAL del archivo analizando su contenido
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $archivo["tmp_name"]);
                finfo_close($finfo);

                $tipos_permitidos = ['image/jpeg', 'image/png'];
                
                if (!in_array($mime, $tipos_permitidos)) {
                    $errores[] = "Formato no válido. Solo se admiten archivos reales JPG o PNG.";
                } else {
                    // 4. Generar un nombre seguro y único (evitamos usar el nombre original del usuario)
                    $extension = ($mime === 'image/png') ? '.png' : '.jpg';
                    // Ejemplo de nombre: avatar_14_1708456213.jpg
                    $nombre_archivo = "avatar_" . $id . "_" . time() . $extension;
                    
                    // 5. Mover el archivo a la carpeta final
                    if (move_uploaded_file($archivo["tmp_name"], "../uploads/" . $nombre_archivo)) {
                        $avatar_nuevo = $nombre_archivo;
                    } else {
                        $errores[] = "Error al guardar la imagen en el servidor.";
                    }
                }
            }
        }
    }

    if ($nombre === "") $errores[] = "El nombre es obligatorio.";
    if ($apellidos === "") $errores[] = "Los apellidos son obligatorios.";
    if ($alias === "") $errores[] = "El alias es obligatorio.";
    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    if ($email !== $confirm_email) $errores[] = "Los emails no coinciden.";

    $actualizar_password = false;
    if ($password !== "" || $confirm_password !== "") {
        if ($password !== $confirm_password) $errores[] = "Las contraseñas no coinciden.";
        elseif (strlen($password) < 6) $errores[] = "La contraseña debe tener al menos 6 caracteres.";
        else {
            $actualizar_password = true;
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    if (empty($errores)) {
        if ($actualizar_password) {
            $sql_update = "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', telefono='$telefono', alias='$alias', email='$email', sexo='$sexo', posicion='$posicion', nivel='$nivel', avatar='$avatar_nuevo', password='$password_hash' WHERE id=$id";
        } else {
            $sql_update = "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', telefono='$telefono', alias='$alias', email='$email', sexo='$sexo', posicion='$posicion', nivel='$nivel', avatar='$avatar_nuevo' WHERE id=$id";
        }

        if ($conexion->query($sql_update)) {
            $_SESSION["usuario_nombre"] = $nombre;
            $_SESSION["usuario_alias"] = $alias;
            echo json_encode(["status" => "success", "mensaje" => "Perfil actualizado correctamente."]);
        } else {
            echo json_encode(["status" => "error", "errores" => ["Error de base de datos."]]);
        }
    } else {
        echo json_encode(["status" => "error", "errores" => $errores]);
    }
    exit;
}

// 2. OBTENER DATOS PARA MOSTRAR EN EL FORMULARIO
$sql_datos = "SELECT * FROM usuarios WHERE id = $id";
$res_datos = $conexion->query($sql_datos);
$usuario_datos = $res_datos->fetch_assoc();

// Preparamos la ruta de la foto
$ruta_foto_actual = ($usuario_datos['avatar']) ? "../uploads/" . $usuario_datos['avatar'] : "../Imágenes/default-avatar.jpg";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelOrgaz-Editar Perfil</title>
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
        <div id="menu">
            <a href="../Pantalla_inicio/inicio.php">Inicio</a>
            <a href="../Reserva/reserva.php">Reserva de pistas</a>
            <a href="../Jugadores/jugadores.php">Ranking de jugadores</a>
            <a href="../Clases/clases.php">Clases</a>
            <a href="../Información/informacion.php">Información</a>
            <a href="perfil.php" class="activo">Mi perfil</a>
        </div>
    </div>

    <div id="recuadro">
        <h2>Editar Perfil</h2>
        <a href="perfil.php">Volver a mi perfil</a>

        <div id="caja-mensajes" style="display: none; padding: 15px; margin-top: 15px; border-radius: 8px; font-weight: bold; text-align: center;"></div>

        <div id="recuadroregistro">
            <form id="form-perfil" enctype="multipart/form-data">
                
                <div class="titulitos"><div class="emoji">💻</div>Datos Personales:</div>
                <div class="alineacion"><label for="Nombre">Nombre:</label><input type="text" id="Nombre" name="Nombre" value="<?= htmlspecialchars($usuario_datos['nombre']) ?>"></div>
                <div class="alineacion"><label for="Apellidos">Apellidos:</label><input type="text" id="Apellidos" name="Apellidos" value="<?= htmlspecialchars($usuario_datos['apellidos']) ?>"></div>
                <div class="alineacion"><label for="Telefono">Teléfono:</label><input type="text" id="telefono" name="telefono" maxlength="9" pattern="[0-9]{9}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?= htmlspecialchars($usuario_datos['telefono']) ?>"></div>
                <div class="alineacion"><label for="Alias">Alias:</label><input type="text" id="Alias" name="Alias" value="<?= htmlspecialchars($usuario_datos['alias']) ?>"></div>
                <hr class="lineas">

                <div class="titulitos"><div class="emoji">🔒</div>Datos de acceso:</div>
                <div class="alineacion"><label for="new_username">Email:</label><input type="email" id="new_username" name="new_username" value="<?= htmlspecialchars($usuario_datos['email']) ?>"></div>
                <div class="alineacion"><label for="confirm_email">Confirmar email:</label><input type="email" id="confirm_email" name="confirm_email" value="<?= htmlspecialchars($usuario_datos['email']) ?>"></div>
                <div class="alineacion"><label for="password">Nueva contraseña:</label><input type="password" id="password" name="password" placeholder="Opcional"></div>
                <div class="alineacion"><label for="confirm_password">Confirmar nueva:</label><input type="password" id="confirm_password" name="confirm_password"></div>
                <hr class="lineas">

                <div class="titulitos"><div class="emoji">🥎</div>Datos de juego:</div>
                <div class="alineacion">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo">
                        <option value="masculino" <?= $usuario_datos['sexo'] == "masculino" ? "selected" : "" ?>>Masculino</option>
                        <option value="femenino" <?= $usuario_datos['sexo'] == "femenino" ? "selected" : "" ?>>Femenino</option>
                        <option value="otro" <?= $usuario_datos['sexo'] == "otro" ? "selected" : "" ?>>Otro</option>
                    </select>
                </div>
                <div class="alineacion">
                    <label for="posicion">Posición:</label>
                    <select id="posicion" name="posicion">
                        <option value="drive" <?= $usuario_datos['posicion'] == "drive" ? "selected" : "" ?>>Drive</option>
                        <option value="reves" <?= $usuario_datos['posicion'] == "reves" ? "selected" : "" ?>>Revés</option>
                        <option value="ambas" <?= $usuario_datos['posicion'] == "ambas" ? "selected" : "" ?>>Ambas</option>
                    </select>
                </div>
                <div class="alineacion"><label for="nivel">Nivel de juego:</label><input type="number" id="nivel" name="nivel" min="1" max="7" step="0.25" value="<?= $usuario_datos['nivel'] ?>" readonly style="background-color: #e9ecef; cursor: not-allowed; color: #666;"></div>
                <hr class="lineas">

                <div class="titulitos"><div class="emoji">👤</div>Avatar:</div>
                <div class="campo-foto" style="text-align: center; margin-bottom: 25px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 10px; color: #1e293b;">Tu foto actual</label>
                    
                    <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 15px;">
                        <img src="<?= $ruta_foto_actual ?>" 
                            alt="Avatar" 
                            style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #00a859; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"
                            onerror="this.src='../Imágenes/default-avatar.jpg'">
                    </div>

                    <div style="background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px dashed #cbd5e1; display: inline-block;">
                        <input type="file" name="sustituir" id="sustituir" accept="image/*">
                    </div>
                    <p style="font-size: 12px; color: #64748b; margin-top: 5px;">Formatos admitidos: JPG, PNG. Máx 2MB.</p>
                </div>
                <hr class="lineas">
                <button type="submit">Guardar cambios</button>
            </form>
        </div>
    </div>
    <footer><p>© 2025 Padelorgaz.</p></footer>

    <script>
        document.getElementById("sustituir").addEventListener("change", function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById("img-preview");
            if (file) { preview.src = URL.createObjectURL(file); preview.style.display = "block"; }
        });

        const formPerfil = document.getElementById("form-perfil");
        const cajaMensajes = document.getElementById("caja-mensajes");

        formPerfil.addEventListener("submit", function(event) {
            event.preventDefault();
            cajaMensajes.style.display = "none";
            const formData = new FormData(formPerfil);
            formData.append("ajax", "1");

            fetch("", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                cajaMensajes.style.display = "block";
                if (data.status === "error") {
                    cajaMensajes.style.cssText = "display:block; padding:15px; margin-top:15px; border-radius:8px; font-weight:bold; background-color:#fff1f2; color:#e11d48; border:1px solid #e11d48;";
                    cajaMensajes.innerHTML = "<ul style='text-align:left; margin:0;'>" + data.errores.map(e => `<li>${e}</li>`).join("") + "</ul>";
                } else {
                    cajaMensajes.style.cssText = "display:block; padding:15px; margin-top:15px; border-radius:8px; font-weight:bold; text-align:center; background-color:#e0f2e9; color:#2e7d32; border:1px solid #2e7d32;";
                    cajaMensajes.innerHTML = "✅ " + data.mensaje;
                    setTimeout(() => window.location.href = "perfil.php", 2000);
                }
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        });
    </script>
</body>
</html>