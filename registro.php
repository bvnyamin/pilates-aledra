<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a base de datos
$host = "127.0.0.1";
$usuario = "root";
$contraseña = "";
$bd = "aledrapilates_bd";

$conn = new mysqli($host, $usuario, $contraseña, $bd, 3306);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = "";
$exito = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $passwordPlano = $_POST['password'] ?? '';

    // Validación del nombre
    if (!preg_match("/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/", $nombre)) {
        $mensaje = "❌ El nombre solo puede contener letras y espacios.";
    } else {
        $password = password_hash($passwordPlano, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Usuario (nombre, email, contrasena) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $nombre, $correo, $password);
            if ($stmt->execute()) {
                $mensaje = "✅ ¡Registro exitoso! Serás redirigido al login...";
                $exito = true;
                header("refresh:2;url=login.html");
            } else {
                $mensaje = "❌ Error al registrar: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensaje = "❌ Error en la preparación de la consulta.";
        }
    }
}

$conn->close();
?>