<?php
    // 1. Comprobar que el formulario se envió por POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        die("Acceso no permitido.");
    }

    // 2. Recoger y limpiar datos
    $nombre = $_POST["nombre"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $asunto = $_POST["asunto"] ?? "";
    $correo = $_POST["correo"] ?? "";
    $mensaje = $_POST["mensaje"] ?? "";


    // 3. Validaciones
    $errores = [];

    // Nombre
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }

    // Teléfono (solo números y 9 dígitos)
    if (!preg_match("/^[0-9]{9}$/", $telefono)) {
        $errores[] = "El teléfono debe tener 9 números.";
    }

    // Correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    // Asunto
    if (empty($asunto)) {
        $errores[] = "El asunto es obligatorio.";
    } elseif (!preg_match("/^(?=.*[a-zA-ZáéíóúÁÉÍÓÚñÑ])[a-zA-Z0-9áéíóúÁÉÍÓÚñÑñÑ ]+$/u", $asunto)) {
        $errores[] = "El asunto debe contener letras y puede incluir números, pero no puede ser solo números.";
    }

    // Mensaje
    if (empty($mensaje)) {
        $errores[] = "El mensaje es obligatorio.";
    }

    // 4. Si hay errores, mostrarlos
    if (!empty($errores)) {
        echo "<h2>Errores en el formulario:</h2>";
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "<a href='contacto.html'>Volver al formulario</a>";
        exit;
    }

    // 5. Si todo está bien, enviar correo
    /*$destinatario = "jvidartep05@educarex.es";
    $contenido = "
    Nombre: $nombre
    Teléfono: $telefono
    Correo: $correo
    Asunto: $asunto
    Mensaje:
    $mensaje
    ";

    $headers = "From: $correo\r\nReply-To: $correo\r\n";

    // Enviar email
    mail($destinatario, "Formulario web: $asunto", $contenido, $headers);*/
    echo "<h2>Datos recibidos:</h2>";
    echo "Nombre: $nombre<br>";
    echo "Teléfono: $telefono<br>";
    echo "Correo: $correo<br>";
    echo "Asunto: $asunto<br>";
    echo "Mensaje: $mensaje<br>";

    // 6. Mensaje de éxito
    echo "<h2>Mensaje enviado correctamente</h2>";
    echo "<p>Gracias por contactar con nosotros, $nombre.</p>";
    echo "<a href='contacto.html'>Volver al inicio</a>";




?>