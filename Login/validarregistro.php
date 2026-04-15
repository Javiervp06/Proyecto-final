<?php
    // 1. Comprobar que el formulario se envió por POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        die("Acceso no permitido.");
    }

    $nombre = $_POST["Nombre"] ?? "";
    $apellidos = $_POST["Apellidos"] ?? "";
    $telefono = $_POST["Telefono"] ?? "";
    $alias = $_POST["Alias"] ?? "";

    $email = $_POST["new_username"] ?? "";
    $confirmar_email = $_POST["confirm_email"] ?? "";
    $contrasena = $_POST["password"] ?? "";
    $confirmar_contrasena = $_POST["confirm_password"] ?? "";

    $sexo = $_POST["sexo"] ?? "";
    $posicion = $_POST["posicion"] ?? "";
    $nivel = $_POST["nivel"] ?? "";
    $nivel = str_replace(",", ".", $nivel);
    $avatar_ruta = null;

    $errores = [];

    // Validar campos
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $nombre)) {
        $errores[] = "El nombre solo puede contener letras.";
    } elseif (strlen($nombre) < 2 || strlen($nombre) > 50) {
        $errores[] = "El nombre debe tener entre 2 y 50 caracteres.";
    }

    if (empty($apellidos)) {
        $errores[] = "Los apellidos son obligatorios.";
    } else if (!preg_match("/^[a-zA-Z\s]+$/", $apellidos)) {
        $errores[] = "Los apellidos solo pueden contener letras y espacios.";
    } elseif (strlen($apellidos) < 6 || strlen($apellidos) > 100) {
        $errores[] = "Los apellidos deben tener entre 6 y 100 caracteres.";
    }

    if (empty($telefono)) {
        $errores[] = "El teléfono es obligatorio.";
    } else if (!preg_match("/^\d{9}$/", $telefono)) {
        $errores[] = "El teléfono debe tener 9 dígitos.";
    }

    if (empty($alias)) {
        $errores[] = "El alias es obligatorio.";
    } else if (!preg_match("/^[a-zA-Z0-9]+$/", $alias)) {
        $errores[] = "El alias solo puede contener letras y números.";
    } elseif (strlen($alias) < 3 || strlen($alias) > 20) {
        $errores[] = "El alias debe tener entre 3 y 20 caracteres.";
    }

    if (empty($email)) {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    } elseif ($email !== $confirmar_email) {
        $errores[] = "Los correos electrónicos no coinciden.";
    }

    if (empty($contrasena)) {
        $errores[] = "La contraseña es obligatoria.";
    } else if (strlen($contrasena) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    } else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/", $contrasena)) {
        $errores[] = "La contraseña debe contener al menos una mayúscula, una minúscula y un número.";
    }

    if (empty($confirmar_contrasena)) {
        $errores[] = "Es necesario confirmar la contraseña.";
    } else if ($contrasena !== $confirmar_contrasena) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    if (empty($sexo)) {
        $errores[] = "El sexo es obligatorio.";
    } 

    if (empty($posicion)) {
        $errores[] = "La posición es obligatoria.";
    } 

    if ($nivel === "") {
        $errores[] = "El nivel es obligatorio.";
    } elseif (!is_numeric($nivel)) {
        $errores[] = "El nivel debe ser un número válido.";
    } elseif ($nivel < 1 || $nivel > 7) {
        $errores[] = "El nivel debe estar entre 1 y 7.";
    }

    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color: red;'>$error</p>";
        }

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
    echo "Apellidos: $apellidos<br>";
    echo "Teléfono: $telefono<br>";
    echo "Alias: $alias<br>";
    echo "Correo: $email<br>";
    echo "Contraseña: $contrasena<br>";
    echo "Sexo: $sexo<br>";
    echo "Posición: $posicion<br>";
    echo "Nivel: $nivel<br>";


    // 6. Mensaje de éxito
    echo "<h2>Mensaje enviado correctamente</h2>";
    echo "<p>Gracias por registrarte, $nombre.</p>";
    echo "<a href='perfil.php'>Volver a tu perfil</a>";

    require_once "../bdd/config.php";

    $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios 
    (nombre, apellidos, telefono, alias, email, password, sexo, posicion, nivel, avatar)
    VALUES 
    ('$nombre', '$apellidos', '$telefono', '$alias', '$email', '$password_hash', '$sexo', '$posicion', '$nivel', '$avatar_ruta')";

    if ($conexion->query($sql)) {
        echo "<h2>Registro completado correctamente</h2>";
    } else {
        echo "Error: " . $conexion->error;
    }

?>
