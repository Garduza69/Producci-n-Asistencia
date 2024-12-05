<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "u712195824_sistema";
$password = "Cruzazul443";
$dbname = "u712195824_sistema";

// Intentar establecer la conexión
$db = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("la conexión ha fallado: " . $conn->connect_error);
}
?>