<?php
session_start(); 

// Mostrar errores en desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$host = "127.0.0.1";
$usuario = "root";
$contraseña = "";
$bd = "aledrapilates_bd";

$conn = new mysqli("127.0.0.1", "root", "", "aledrapilates_bd", 3306);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$correo = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';


// Validación básica
if (empty($correo) || empty($password)) {
    die("Por favor completa todos los campos.");
}

// Buscar el usuario en la base de datos
$sql = "SELECT id, nombre, contrasena FROM Usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // Verificar contraseña
    if (password_verify($password, $usuario['contrasena'])) {
        echo "<h2>¡Inicio de sesión exitoso, bienvenido " . htmlspecialchars($usuario['nombre']) . "!</h2>";
        // Aquí podrías guardar info en sesión
        // $_SESSION['usuario_id'] = $usuario['id'];
        // header("Location: dashboard.php");
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "No se encontró una cuenta con ese correo.";
}

$stmt->close();
$conn->close();
?>