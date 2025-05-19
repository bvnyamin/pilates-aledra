<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$host = "127.0.0.1";
$usuario = "root";
$contraseña = "";
$bd = "aledrapilates_bd";

$conn = new mysqli($host, $usuario, $contraseña, $bd, 3306);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se enviaron datos
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    die("Por favor completa todos los campos.");
}

$email = $_POST['email'];
$password = $_POST['password'];

// Buscar el usuario
$sql = "SELECT * FROM Usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    if (password_verify($password, $usuario['contrasena'])) {
        // Iniciar sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        // Redirigir según el rol
        if ($usuario['rol'] === 'administrador') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: bienvenida2.php");
        }
        exit;
        
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Correo no registrado.";
}

$stmt->close();
$conn->close();
?>
