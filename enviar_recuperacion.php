<?php
include("conexion_bd.php"); 

$email = $_POST['email'];

// Verificar que el correo existe en la tabla Usuario
$query = $conn->prepare("SELECT * FROM Usuario WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$resultado = $query->get_result();

if ($resultado->num_rows > 0) {
    $token = bin2hex(random_bytes(16));
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Guardar token en tabla
    $stmt = $conn->prepare("INSERT INTO RecuperacionPassword (email, token, fechaExpiracion) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expira);
    $stmt->execute();

    // Enlace de recuperación
    $link = "http://localhost/aledra-pilates/restablecer.php?token=$token";

    // Simulación de envío de email (sólo muestra en pantalla)
    echo "Enlace de recuperación: <a href='$link'>$link</a>";
} else {
    echo "Correo no encontrado";
}
?>
