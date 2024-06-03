<?php 
$host = 'localhost';
$db_name = 'exemple_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}
?>