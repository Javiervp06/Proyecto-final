<?php
session_start();
require_once "../bdd/config.php";
require_once "../bdd/enviar_correo.php";

$id_usuario = $_SESSION['usuario_id'] ?? null;

if (!$id_usuario) {
    die("Error: Debes iniciar sesión para reservar.");
}

    $dia = $_POST['dia'];
    $hora = $_POST['hora'];
    $hora_fin = $_POST['hora_fin'];
    $pista = $_POST['pista'];
    $nivel = $_POST['nivel'];
    $jugadores = (int)$_POST['jugadores']; // Plazas que quiere reservar

    // FUNCIÓN PARA MOSTRAR MENSAJES BONITOS 
    function mostrarErrorEstilizado($titulo, $mensaje) {
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Aviso - PadelOrgaz</title>
            <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap' rel='stylesheet'>
            <style>
                body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #F8FAFC; font-family: 'Montserrat', sans-serif; margin: 0; }
                .error-card { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); text-align: center; max-width: 450px; border-top: 6px solid #e11d48; animation: fadeIn 0.4s ease-out; }
                @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
                .error-icon { font-size: 55px; margin-bottom: 15px; }
                .error-title { color: #1e293b; font-size: 24px; margin-bottom: 15px; font-weight: 700; }
                .error-text { color: #475569; font-size: 15px; line-height: 1.6; margin-bottom: 30px; }
                .btn-volver { background-color: #0A58CA; color: white; border: none; padding: 14px 28px; border-radius: 8px; font-weight: 600; font-size: 15px; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(10, 88, 202, 0.3); }
                .btn-volver:hover { background-color: #084298; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(10, 88, 202, 0.4); }
            </style>
        </head>
        <body>
            <div class='error-card'>
                <div class='error-icon'>🚫</div>
                <div class='error-title'>$titulo</div>
                <div class='error-text'>$mensaje</div>
                <a href='javascript:history.back()' class='btn-volver'>Volver a la reserva</a>
            </div>
        </body>
        </html>";
        exit();
    }

    // 1. VALIDACIÓN DE NIVEL PARA JUGADORES QUE SE UNEN
    $sql_user = "SELECT nombre, email, nivel FROM usuarios WHERE id = $id_usuario";
    $datos_user = $conexion->query($sql_user)->fetch_assoc();
    $nivel_usuario = (float)$datos_user['nivel'];
    $email_usuario = $datos_user['email'];

    $sql_existe = "SELECT r.nivel as restriccion, u.nivel as nivel_creador 
                   FROM reservas r 
                   JOIN usuarios u ON r.id_usuario = u.id 
                   WHERE r.dia = ? AND r.hora_inicio = ? AND r.pista_id = ? 
                   ORDER BY r.creado_en ASC LIMIT 1"; 
    $stmt_existe = $conexion->prepare($sql_existe);
    $stmt_existe->bind_param("ssi", $dia, $hora, $pista);
    $stmt_existe->execute();
    $res_existe = $stmt_existe->get_result();

    if ($res_existe->num_rows > 0) {
        $partida = $res_existe->fetch_assoc();
        $restriccion = strtolower(trim($partida['restriccion'])); 
        $nivel_creador = (float)$partida['nivel_creador'];

        preg_match('/[0-9]+(\.[0-9]+)?/', $restriccion, $coincidencias);
        
        if ($restriccion !== 'todos' && !empty($coincidencias)) {
            $margen = (float)$coincidencias[0];
            $diferencia = abs($nivel_creador - $nivel_usuario);
            
            if ($diferencia > $margen) {
                // LLAMAMOS A NUESTRA NUEVA PANTALLA BONITA
                mostrarErrorEstilizado(
                    "Nivel no permitido", 
                    "Tu nivel es <strong>" . number_format($nivel_usuario, 2) . "</strong> y el creador de la pista (Nivel " . number_format($nivel_creador, 2) . ") solo permite una diferencia de <strong>±" . $margen . "</strong>."
                );
            }
        }
    }

    // 2. COMPROBAR PLAZAS LIBRES
    $sql_check = "SELECT SUM(jugadores) as total FROM reservas WHERE dia=? AND hora_inicio=? AND pista_id=?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("ssi", $dia, $hora, $pista);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();
    $row_check = $res_check->fetch_assoc();
    $total_actual = (int)$row_check['total'];
    $total_final = $total_actual + $jugadores;

    if ($total_final > 4) {
        // APLICAMOS EL MISMO ESTILO AL ERROR DE PLAZAS
        mostrarErrorEstilizado(
            "Plazas insuficientes", 
            "Intentas reservar <strong>$jugadores</strong> plaza(s), pero solo quedan <strong>" . (4 - $total_actual) . "</strong> libre(s) en esta pista."
        );
    }

// 2. OBTENER DATOS DEL USUARIO (Para enviarle el correo)
$sql_user = "SELECT nombre, email FROM usuarios WHERE id = $id_usuario";
$datos_user = $conexion->query($sql_user)->fetch_assoc();
$email_usuario = $datos_user['email'];
$nombre_usuario = $datos_user['nombre'];

// 3. INSERTAR LA RESERVA DE FORMA SEGURA
$sql = "INSERT INTO reservas (dia, hora_inicio, hora_fin, pista_id, id_usuario, nivel, jugadores) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssiisi", $dia, $hora, $hora_fin, $pista, $id_usuario, $nivel, $jugadores);

if ($stmt->execute()) {
    $stmt->close();

    // 📧 CORREO 1: CONFIRMACIÓN INDIVIDUAL
    $asunto1 = "Confirmacion de reserva - PadelOrgaz";
    $cuerpo1 = "Hola $nombre_usuario,\n\nTu plaza para el partido del dia $dia a las $hora ha sido confirmada.\n\n¡Nos vemos en la pista!";
    
    mandarCorreoSMTP($email_usuario, $asunto1, $cuerpo1);

    // 1. RE-CALCULAR EL TOTAL REAL (Asegurando formato)

    $hora_busqueda = substr($hora, 0, 5) . "%"; 

    $sql_count = "SELECT SUM(jugadores) as total FROM reservas WHERE dia=? AND hora_inicio LIKE ? AND pista_id=?";
    $stmt_count = $conexion->prepare($sql_count);
    $stmt_count->bind_param("ssi", $dia, $hora_busqueda, $pista);
    $stmt_count->execute();
    $fila_count = $stmt_count->get_result()->fetch_assoc();
    $total_real = (int)($fila_count['total'] ?? 0);
    $stmt_count->close();

    // 2. LÓGICA DE ENVÍO GRUPAL
    if ($total_real >= 4) {
        // Buscamos los correos agrupando para no repetir
        $sql_emails = "SELECT u.email, u.nombre FROM reservas r 
                       JOIN usuarios u ON r.id_usuario = u.id 
                       WHERE r.dia = ? AND r.hora_inicio LIKE ? AND r.pista_id = ?
                       GROUP BY u.email";
        
        $stmt_emails = $conexion->prepare($sql_emails);
        $stmt_emails->bind_param("ssi", $dia, $hora_busqueda, $pista);
        $stmt_emails->execute();
        $res_emails = $stmt_emails->get_result();

        $num_jugadores_distintos = $res_emails->num_rows;

        if ($num_jugadores_distintos > 0) {
            $enviados_con_exito = 0;
            $registro_fallos = ""; 
            
            // Le damos un respiro a Mailtrap antes de empezar los masivos
            sleep(3); 
            
            while ($fila_email = $res_emails->fetch_assoc()) {
                $destinatario = trim($fila_email['email']);
                $nombre_dest = trim($fila_email['nombre']);
                
                // ¡Puedes volver a poner la pelota de tenis si quieres! 🎾
                $asunto_grupo = "🎾 ¡Pista Completa! - PadelOrgaz";
                $cuerpo_grupo = "Hola $nombre_dest, la partida del dia $dia a las $hora ya esta completa con 4 jugadores. ¡Nos vemos en la pista!";
                
                $motivo_error = ""; 
                
                if (mandarCorreoSMTP($destinatario, $asunto_grupo, $cuerpo_grupo, $motivo_error)) {
                    $enviados_con_exito++;
                } else {
                    $registro_fallos .= "- Fallo a [$destinatario]. Motivo: $motivo_error\n";
                }
                
                // Esperamos 4 SEGUNDOS para engañar al límite gratuito de Mailtrap
                sleep(4); 
            }
            
            // CORREO DE CONTROL ACTUALIZADO
            $info_final = "Partida completada. Jugadores distintos: $num_jugadores_distintos.\n";
            $info_final .= "Correos enviados con exito: $enviados_con_exito.\n\n";
            $info_final .= "Reporte de fallos:\n$registro_fallos";
            
            mandarCorreoSMTP($email_usuario, "DEBUG: Resultado Envio", $info_final);
            
        } else {
            mandarCorreoSMTP($email_usuario, "DEBUG: Error Critico", "El total es $total_real pero la consulta de correos devolvió 0 filas.");
        }
        $stmt_emails->close();

    } else {
        // Si no llega a 4, nos avisa cuánto sumó realmente
        mandarCorreoSMTP($email_usuario, "DEBUG: No llega a 4", "La suma actual es: " . $total_real);
    }

    // ==========================================
    // FIN: REDIRIGIR AL USUARIO
    // ==========================================
    header("Location: reserva.php");
    exit();
} else {
    die("Error al guardar la reserva: " . $stmt->error);
}
?>