<?php
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method";
    exit;
}

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi inputz
if (empty($username) || empty($email) || empty($password)) {
    echo "All fields are required";
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$role_id = 2; 

try {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :hash, :role_id)");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'hash' => $hash,
        'role_id' => $role_id
    ]);
    
    header('location: ../../../../index.php');
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>