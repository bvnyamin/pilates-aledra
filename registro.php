<?php


ini_set('display_errors', 1);

error_reporting(E_ALL);
// Datos de conexión
$host = "lo127.0.0.1";
$usuario = "root";
$contraseña = ""; 
$bd = "aledrapilates_bd"; 

// Crear conexión
$conn = new mysqli("127.0.0.1", "root", "", "aledrapilates_bd", 3306);



// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
var_dump($_POST);  // Encriptar contraseña

// Insertar datos
$sql = "INSERT INTO Usuario (nombre, email, contrasena) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nombre, $correo, $password);

if ($stmt->execute()) {
    echo "¡Registro exitoso! Serás redirigido al login...";
    header("refresh:2;url=login.html"); 
    exit;
}

$stmt->close();
$conn->close();
?>