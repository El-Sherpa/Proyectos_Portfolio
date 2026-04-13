<?php
// Configuración de la base de datos
$host = "127.0.0.1";
$port = 3306;
$socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";
$db_name = "agecso";
$username = "root";
$password = ""; // Por defecto en XAMPP está vacío

try {
    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8mb4", $username, $password);
    } catch (PDOException $e) {
        $pdo = new PDO("mysql:unix_socket=$socket;dbname=$db_name;charset=utf8mb4", $username, $password);
    }
    // Configurar el modo de error de PDO para que lance excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configurar el modo de obtención por defecto a array asociativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
