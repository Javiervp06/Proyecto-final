<?php
session_start();
require_once "../bdd/config.php"; 
require_once "../bdd/enviar_correo.php"; 

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$id_usuario_actual = $_SESSION["usuario_id"];

if (isset($_GET['id'])) {
    $id_reserva = (int)$_GET['id'];
    
    // 1. OBTENEMOS LOS DATOS DE LA RESERVA (Día, hora y pista) ANTES DE BORRARLA
    $sql_datos = "SELECT dia, hora_inicio, pista_id FROM reservas WHERE id = ? AND id_usuario = ?";
    $stmt_datos = $conexion->prepare($sql_datos);
    $stmt_datos->bind_param("ii", $id_reserva, $id_usuario_actual);
    $stmt_datos->execute();
    $res_datos = $stmt_datos->get_result();
    
    if ($res_datos->num_rows === 1) {
        $datos_reserva = $res_datos->fetch_assoc();
        $dia = $datos_reserva['dia'];
        $hora_inicio = $datos_reserva['hora_inicio'];
        $pista_id = $datos_reserva['pista_id'];
        
        // 2. COMPROBAMOS SI LA PARTIDA ESTABA LLENA ANTES DE BORRAR
        $sql_total = "SELECT SUM(jugadores) as total FROM reservas WHERE dia = ? AND hora_inicio = ? AND pista_id = ?";
        $stmt_total = $conexion->prepare($sql_total);
        $stmt_total->bind_param("ssi", $dia, $hora_inicio, $pista_id);
        $stmt_total->execute();
        $fila_total = $stmt_total->get_result()->fetch_assoc();
        $total_antes = (int)($fila_total['total'] ?? 0);
        $stmt_total->close();

        // 3. BORRAMOS LA RESERVA DEL USUARIO
        $sql_del = "DELETE FROM reservas WHERE id = ?";
        $stmt_del = $conexion->prepare($sql_del);
        $stmt_del->bind_param("i", $id_reserva);
        $stmt_del->execute();
        $stmt_del->close();

        // 4. SI LA PARTIDA ESTABA LLENA (4) Y ALGUIEN SE HA BORRADO, AVISAMOS A LOS DEMÁS
        if ($total_antes >= 4) {
            
            // Buscamos a los jugadores que QUEDAN en esa pista
            $sql_resto = "SELECT u.email, u.nombre FROM reservas r 
                          JOIN usuarios u ON r.id_usuario = u.id 
                          WHERE r.dia = ? AND r.hora_inicio = ? AND r.pista_id = ?
                          GROUP BY u.email";
            
            $stmt_resto = $conexion->prepare($sql_resto);
            $stmt_resto->bind_param("ssi", $dia, $hora_inicio, $pista_id);
            $stmt_resto->execute();
            $res_resto = $stmt_resto->get_result();
            
            if ($res_resto->num_rows > 0) {
                // Le damos un respiro a Mailtrap antes de empezar
                sleep(2); 
                
                $fecha_formateada = date("d/m/Y", strtotime($dia));
                $hora_formateada = substr($hora_inicio, 0, 5);

                while ($fila_email = $res_resto->fetch_assoc()) {
                    $destinatario = trim($fila_email['email']);
                    $nombre_dest = trim($fila_email['nombre']);
                    
                    $asunto = "⚠️ Hueco libre en tu partido - PadelOrgaz";
                    $cuerpo = "Hola $nombre_dest, te avisamos de que un jugador ha cancelado su plaza en tu partido del dia $fecha_formateada a las $hora_formateada h. <br><br>La pista vuelve a estar abierta, ¡avisad a un amigo para completar el hueco!";
                    
                    $motivo_error = "";
                    mandarCorreoSMTP($destinatario, $asunto, $cuerpo, $motivo_error);
                    
                    // Esperamos 4 segundos para no bloquear Mailtrap
                    sleep(4); 
                }
            }
            $stmt_resto->close();
        }

        // 5. DEVOLVEMOS AL USUARIO A SU PERFIL
        header("Location: perfil.php?mensaje=cancelada");
        
    } else {
        // Si intenta borrar una reserva que no existe o no es suya
        header("Location: perfil.php?mensaje=error");
    }
    
    $stmt_datos->close();
    
} else {
    header("Location: perfil.php");
}
exit();
?>