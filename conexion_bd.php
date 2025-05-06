<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; 
$bd = "aledrapilates_bd";

// Crear conexión
$conn = new mysqli("127.0.0.1", "root", "", "aledrapilates_bd", 3306);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>