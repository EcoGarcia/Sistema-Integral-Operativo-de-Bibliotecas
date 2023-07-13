<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_POST['recover'])) {
    $email = $_POST['email'];

    // Verificar si el correo electrónico existe en la base de datos
    $sql = "SELECT * FROM users WHERE email = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        // Generar una nueva contraseña aleatoria
        $newPassword = generateRandomPassword();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        // Enviar la nueva contraseña al correo electrónico del usuario
        $to = $email;
        $subject = "Recuperación de contraseña";
        $message = "Su nueva contraseña es: " . $newPassword;
        $headers = "From: your-email@example.com" . "\r\n";

        // Envío del correo electrónico
        if (mail($to, $subject, $message, $headers)) {
            echo "<script>alert('Se ha enviado una nueva contraseña a su correo electrónico. Por favor, verifique su bandeja de entrada.');</script>";
        } else {
            echo "<script>alert('Ha ocurrido un error al enviar el correo electrónico. Por favor, inténtelo de nuevo más tarde.');</script>";
        }
    } else {
        echo "<script>alert('El correo electrónico ingresado no existe en nuestra base de datos. Por favor, verifique e intente nuevamente.');</script>";
    }
}

// Generar una contraseña aleatoria de 8 caracteres
function generateRandomPassword()
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = "";

    for ($i = 0; $i < 8; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }

    return $password;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recuperación de Contraseña</title>
</head>
<body>
    <h1>Recuperación de Contraseña</h1>
    <form method="POST" action="">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit" name="recover">Recuperar Contraseña</button>
    </form>
</body>
</html>
