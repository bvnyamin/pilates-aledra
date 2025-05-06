<?php
include("conexion_bd.php");

$mensaje = "";

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $nueva_password = password_hash($_POST['nueva_password'], PASSWORD_DEFAULT);

    $sql = "UPDATE Usuario SET contrasena = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $nueva_password, $email);
        if ($stmt->execute()) {
            $mensaje = "✅ Contraseña actualizada correctamente. <a href='login.html'>Iniciar sesión</a>";
        } else {
            $mensaje = "❌ Error al actualizar la contraseña: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensaje = "❌ Error en la preparación de la consulta: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <div class="info">
            <p class="txt-1">Recupera tu acceso</p>
            <h2>ALedra pilates studio</h2>
            <hr>
            <p class="txt-2">Vuelve a conectarte con tu bienestar.</p>
            <hr>
            <p class="txt-2">Recuperar tu contraseña es el primer paso.</p>
        </div>

        <form class="form" action="" method="POST">
            <h2>Restablecer tu contraseña</h2>
            <div class="inputs">
                <input type="email" name="email" class="box" placeholder="Correo asociado" required>
                <input type="password" name="nueva_password" class="box" placeholder="Nueva contraseña" required>
                <input type="submit" value="Actualizar contraseña" class="submit">
            </div>
            <?php if (!empty($mensaje)): ?>
                <p style="color: green; text-align: center; margin-top: 10px;"><?php echo $mensaje; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>