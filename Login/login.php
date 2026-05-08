<?php
session_start();
require_once "../bdd/config.php"; // Asegúrate de que la ruta a tu BD es correcta

// 1. Si ya tiene sesión abierta por defecto, lo mandamos directo a inicio
if (isset($_SESSION['usuario_id'])) {
    header("Location: ../Pantalla_inicio/inicio.php");
    exit();
}

// 2. MAGIA DE RECORDARME: No tiene sesión, pero SÍ tiene la llave (Cookie)
if (isset($_COOKIE['recuerdame_id'])) {
    $cookie_id = (int)$_COOKIE['recuerdame_id'];
    
    // Buscamos a ese usuario en la base de datos
    $sql_cookie = "SELECT id, nombre, alias, rol FROM usuarios WHERE id = ?";
    $stmt_cookie = $conexion->prepare($sql_cookie);
    $stmt_cookie->bind_param("i", $cookie_id);
    $stmt_cookie->execute();
    $res_cookie = $stmt_cookie->get_result();
    
    // Si el usuario existe, le reconstruimos la sesión sin que tenga que teclear nada
    if ($res_cookie->num_rows === 1) {
        $usuario = $res_cookie->fetch_assoc();
        
        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_nombre"] = $usuario["nombre"];
        $_SESSION["usuario_alias"] = $usuario["alias"];
        $_SESSION["rol"] = $usuario["rol"];
        
        header("Location: ../Pantalla_inicio/inicio.php");
        exit();
    }
}
?>

<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PadelOrgaz - Inicio de sesión</title>
        <link rel="stylesheet" href="../css/inicio.css">
        <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
        
        <style>
            #recuadro {
                width: 90%; /* Le decimos que intente ocupar más ancho */
                max-width: 800px; /* Subimos el tope máximo a 800px */
                margin: 50px auto; 
                padding: 50px; /* Más espacio en blanco por dentro para que respire */
                box-sizing: border-box;
            }
            
            .login {
                width: 85%; /* El formulario ocupará casi toda la caja blanca */
                margin: 20px auto 0 auto; /* Lo centramos perfectamente */
            }

            .login label {
                font-size: 18px; /* Hacemos los textos de "Correo" y "Contraseña" un poco más grandes */
                margin-bottom: 10px;
            }

            .login input[type="email"],
            .login input[type="password"] {
                width: 100%; 
                box-sizing: border-box;
                padding: 15px; /* Barras de texto más altas y cómodas para hacer clic */
                font-size: 18px; /* Letra más grande al escribir */
                margin-bottom: 15px;
            }
            
            .recordarme {
                font-size: 16px; /* Texto de recordarme un poco más grande */
                margin-bottom: 15px;
            }

            .login button {
                width: 100%; 
                padding: 16px; /* Botón azul bastante más grande y llamativo */
                font-size: 20px;
                font-weight: bold;
                margin-top: 15px;
                margin-bottom: 25px;
            }

            .login p, .login a {
                font-size: 16px; /* Textos de abajo ("Regístrate aquí") más legibles */
            }
        </style>
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
            <h2>Inicio de sesión</h2>
            <div class="login">
                <div id="caja-mensajes" style="display: none; padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: bold; text-align: center;"></div>
                
                <form id="form-login">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email"><br>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password"><br>

                    <div class="recordarme">
                        <input type="checkbox" id="remember" name="remember">
                        <span>Recordarme</span>
                    </div>
                    <br>
                    <button type="submit">Iniciar sesión</button>

                    <div style="margin-top: 15px; text-align: center;">
                        <a href="olvida_contrasena.php" style="color: #6C757D; font-size: 13px; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#0A58CA'" onmouseout="this.style.color='#6C757D'">
                            ¿Has olvidado tu contraseña?
                        </a>
                    </div>
                </form>
                <p>¿No tienes una cuenta? <a href="registrarse.php">Regístrate aquí</a></p>
            </div>
        </div>
        <footer><p>© 2025 Padelorgaz.</p></footer>

        <script>
            const formLogin = document.getElementById("form-login");
            const cajaMensajes = document.getElementById("caja-mensajes");

            formLogin.addEventListener("submit", function(event) {
                event.preventDefault();
                const formData = new FormData(formLogin);
                
                fetch("validarlogin.php", { method: "POST", body: formData })
                .then(res => res.json())
                .then(data => {
                    cajaMensajes.style.display = "block";
                    if (data.status === "error") {
                        cajaMensajes.style.cssText = "display:block; padding:15px; margin-bottom:20px; border-radius:8px; font-weight:bold; background-color:#fff1f2; color:#e11d48; border:1px solid #e11d48;";
                        cajaMensajes.innerHTML = "❌ " + data.mensaje;
                    } else {
                        cajaMensajes.style.cssText = "display:block; padding:15px; margin-bottom:20px; border-radius:8px; font-weight:bold; text-align:center; background-color:#e0f2e9; color:#2e7d32; border:1px solid #2e7d32;";
                        cajaMensajes.innerHTML = "✅ " + data.mensaje;
                        setTimeout(() => window.location.href = "../Pantalla_inicio/inicio.php", 1500);
                    }
                });
            });
        </script>
    </body>
</html>
