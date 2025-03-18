<?php
$host = "localhost";
$db_name = "assets-metik";
$user = "root";
$pass = "";

try{
    $conn = new PDO("mysql:host=$host; dbname=$db_name", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi gagal" . $e->getMessage());
} 

?>