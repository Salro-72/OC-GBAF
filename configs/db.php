<?php
define('server', 'localhost');
define('user_name', 'root');
define('password', '');
define('database', 'demo');

try{
    $pdo = new PDO("mysql:host=" . server . ";dbname=" . database, user_name, password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>