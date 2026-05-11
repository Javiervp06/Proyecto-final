<?php
session_start();

// 1. PROTECCIÓN DE SEGURIDAD: Solo entra el Admin
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== 'admin') {
    header("Location: ../Login/login.php");
    exit();
}

require_once "../bdd/config.php"; 

// 2. PROCESAMIENTO AJAX PARA GUARDAR EL PROFESOR
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ajax"])) {
    header('Content-Type: application/json');

    $nombre = trim($_POST["nombre"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $especialidad = trim($_POST["especialidad"] ?? "");
    $errores = [];

    if ($nombre === "") $errores[] = "El nombre es obligatorio.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El correo no es válido.";
    if (!preg_match("/^[0-9]{9}$/", $telefono)) $errores[] = "El teléfono debe tener 9 números.";
    if ($especialidad === "") $errores[] = "La especialidad es obligatoria.";

    if (empty($errores)) {
        $sql = "INSERT INTO profesores (nombre, email, telefono, especialidad) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssss", $nombre, $email, $telefono, $especialidad);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "mensaje" => "Profesor añadido correctamente a la plantilla."]);
            } else {
                echo json_encode(["status" => "error", "errores" => ["Error al guardar: " . $conexion->error]]);
            }
            $stmt->close();
        }
    } else {
        echo json_encode(["status" => "error", "errores" => $errores]);
    }
    exit;
}

// 3. OBTENER DATOS DEL ADMIN PARA LA CABECERA (Tu foto y tu nombre)
$id_admin = $_SESSION['usuario_id'];
$sql_admin = "SELECT nombre, apellidos, avatar FROM usuarios WHERE id = ?";
$stmt_admin = $conexion->prepare($sql_admin);
$stmt_admin->bind_param("i", $id_admin);
$stmt_admin->execute();
$datos_admin = $stmt_admin->get_result()->fetch_assoc();

$ruta_avatar = ($datos_admin['avatar']) ? "../uploads/" . $datos_admin['avatar'] : "../Imágenes/default-avatar.jpg";
$nombre_completo_admin = $datos_admin['nombre'] . " " . $datos_admin['apellidos'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Añadir Profesores</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/admin.css"> <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <style>
        /* Estilos del formulario adaptados a la zona del contenido admin */
        .admin-panel-box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 700px; margin: 0 auto; }
        .form-admin label { font-weight: bold; margin-bottom: 5px; display: block; color: #334155; }
        .form-admin input, .form-admin select { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 16px; }
        .form-admin input:focus, .form-admin select:focus { outline: none; border-color: #1a3d7c; box-shadow: 0 0 0 2px rgba(26, 61, 124, 0.2); }
        .form-admin button { width: 100%; padding: 14px; background-color: #1a3d7c; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 18px; transition: 0.3s; }
        .form-admin button:hover { background-color: #132a56; }
        .asterisco { color: #e11d48; display: inline; }
        /* Estilos del formulario adaptados a la zona del contenido admin */
        .admin-panel-box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 700px; margin: 0 auto; }
        .form-admin label { font-weight: bold; margin-bottom: 5px; display: block; color: #334155; }
        .form-admin input, .form-admin select { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 16px; }
        .form-admin input:focus, .form-admin select:focus { outline: none; border-color: #1a3d7c; box-shadow: 0 0 0 2px rgba(26, 61, 124, 0.2); }
        .form-admin button { width: 100%; padding: 14px; background-color: #1a3d7c; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 18px; transition: 0.3s; }
        .form-admin button:hover { background-color: #132a56; }
        .asterisco { color: #e11d48; display: inline; }
        
        .header-acciones { display: flex; align-items: center; gap: 20px; }

        /* =========================================
           DISEÑO RESPONSIVE MÓVIL (FORM PROFESORES) 
           ========================================= */
        @media (max-width: 768px) {
            .admin-panel-box { padding: 20px; margin: 10px; }
            .admin-panel-box h2 { font-size: 22px !important; }
            .header-acciones { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body class="admin-body">

    <aside class="admin-sidebar">
        <div class="admin-logo">
            <img src="../Imágenes/Logopaginaweb.png" alt="Logo PadelOrgaz">
            <h2>Admin Panel</h2>
        </div>
        <nav class="admin-menu">
            <a href="admin_inicio.php">📊 Dashboard</a>
            <a href="admin_reservas.php">🎾 Gestión de Reservas</a>
            <a href="admin_jugadores.php">👥 Jugadores / Ranking</a>
            <a href="admin_mensajes.php">📩 Clases y Contacto</a>
            <a href="admin_profesores.php" class="activo">👨‍🏫 Gestionar Profesores</a>
            <div class="spacer"></div> 
            <a href="../Login/cierre_sesion.php" class="logout">🚪 Cerrar Sesión</a>
        </nav>
    </aside>

    <main class="admin-main">
        
        <div class="admin-header">
            <h2>Gestionar Profesores</h2>
            
            <div class="header-acciones">
                <div class="admin-perfil">
                    <span><?= htmlspecialchars($nombre_completo_admin) ?></span>
                    <img src="<?= $ruta_avatar ?>" onerror="this.src='../Imágenes/default-avatar.jpg'" alt="Perfil Admin">
                </div>
            </div>
        </div>

        <div class="admin-content">
            
            <div class="admin-panel-box">
                <h2 style="text-align: center; color: #1e293b; margin-bottom: 10px; font-size: 26px;">Alta de Nuevo Profesor</h2>
                <p style="text-align:center; color:#64748b; margin-bottom:30px;">Rellena los datos para registrar un nuevo monitor en el sistema.</p>

                <div id="caja-mensajes" style="display: none; padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: bold; text-align: center;"></div>

                <form id="form-profesor" class="form-admin">
                    <div>
                        <label for="nombre"><div class="asterisco">*</div> Nombre Completo:</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Carlos Alcaraz">
                    </div>
                    <div>
                        <label for="telefono"><div class="asterisco">*</div> Teléfono:</label>
                        <input type="number" id="telefono" name="telefono" min="600000000" max="999999999" placeholder="Ej: 600123456" maxlength="9">
                    </div>
                    <div>
                        <label for="email"><div class="asterisco">*</div> Correo Electrónico:</label>
                        <input type="email" id="email" name="email" placeholder="Ej: carlos@padelorgaz.com">
                    </div>
                    <div>
                        <label for="especialidad"><div class="asterisco">*</div> Especialidad:</label>
                        <select id="especialidad" name="especialidad">
                            <option value="">Selecciona una opción...</option>
                            <option value="Principiantes">Clases Principiantes</option>
                            <option value="Intermedios">Clases Nivel Medio</option>
                            <option value="Avanzados">Clases Avanzadas / Competición</option>
                            <option value="Menores">Clases Infantiles</option>
                        </select>
                    </div>
                    <button type="submit">Guardar Profesor</button>
                </form>
            </div>

        </div>
    </main>

    <script>
        const formProfesor = document.getElementById("form-profesor");
        const cajaMensajes = document.getElementById("caja-mensajes");

        formProfesor.addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(formProfesor);
            formData.append("ajax", "1"); 

            fetch("admin_profesores.php", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                cajaMensajes.style.display = "block";
                if (data.status === "error") {
                    cajaMensajes.style.cssText = "display:block; padding:15px; margin-bottom:20px; border-radius:8px; font-weight:bold; background-color:#fff1f2; color:#e11d48; border:1px solid #e11d48;";
                    cajaMensajes.innerHTML = "<ul style='text-align:left; margin:0; padding-left:20px;'>" + data.errores.map(e => `<li>${e}</li>`).join("") + "</ul>";
                } else {
                    cajaMensajes.style.cssText = "display:block; padding:15px; margin-bottom:20px; border-radius:8px; font-weight:bold; text-align:center; background-color:#e0f2e9; color:#2e7d32; border:1px solid #2e7d32;";
                    cajaMensajes.innerHTML = "✅ " + data.mensaje;
                    formProfesor.reset(); 
                }
            });
        });
    </script>
</body>
</html>