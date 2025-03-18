<?php
require '../../../assets/backend/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method";
    exit;
}

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$hash = password_hash($password, PASSWORD_DEFAULT);
$role_id = 2; // 2 for user kalo 1 for admin

// Validasi inputz
if (empty($username) || empty($email) || empty($hash)) {
    echo "All fields are required";
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role_id, created_at) VALUES (:username, :email, :hash, :role_id, NOW())");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'hash' => $hash,
        'role_id' => $role_id
    ]);
    
    header('location: ../../users.php');
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>