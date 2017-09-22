<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $db = new PDO('mysql:host=localhost;dbname=AISProject1;charset=utf8mb4', 'root', '');
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>