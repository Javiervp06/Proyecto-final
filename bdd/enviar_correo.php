<?php
// enviar_correo.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargamos los archivos de PHPMailer a mano
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Añadimos &$error_detalle para que la función nos pueda "devolver" el mensaje de error
function mandarCorreoSMTP($destinatario, $asunto, $cuerpo, &$error_detalle = null) {
    $mail = new PHPMailer(true);
    
    try {
        // 1. Configuración del Servidor de Mailtrap
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = '4381f61c9f1a32';      
        $mail->Password   = '3c2961873b18e2';      
        $mail->Port       = 2525;     
        $mail->CharSet    = 'UTF-8';           

        // 2. Remitente y Destinatario
        $mail->setFrom('reservas@padelorgaz.com', 'PadelOrgaz');
        $mail->addAddress($destinatario);

        // 3. Contenido del correo
        $mail->isHTML(true); 
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;

        // 4. Enviar
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        // Si hay un error, lo guardamos en la variable para que el chivato lo lea
        if ($error_detalle !== null) {
            $error_detalle = $mail->ErrorInfo;
        }
        return false; 
    }
}
?>