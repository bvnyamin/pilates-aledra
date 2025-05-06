<?php
include("conexion_bd.php");

$token = $_POST['token'];
$nueva = password_hash($_POST['nueva_password'], PASSWORD_DEFAULT);

$query = $conn->prepare("SELECT email FROM RecuperacionPassword WHERE token = ? AND fechaExpiracion > NOW()");
$query->bind_param("s", $token);
$query->execute();
$resultado = $query->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $email = $fila['email'];

    $stmt = $conn->prepare("UPDATE Usuario SET contrasena = ? WHERE email = ?");
    $stmt->bind_param("ss", $nueva, $email);
    $stmt->execute();

    // Borrar token
    $conn->query("DELETE FROM RecuperacionPassword WHERE token = '$token'");

    echo "¡Contraseña actualizada!";
} else {
    echo "Token inválido o expirado.";
}
?>
