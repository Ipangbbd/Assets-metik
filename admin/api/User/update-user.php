<?php
session_start();
require_once '../../../assets/backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Validate input
    if (empty($id) || empty($username) || empty($email) || empty($hash)) {
        echo "All fields are required";
        exit;
    }
    
    try {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
        $stmt->execute([$username, $email, $hash, $id]);
        header('Location: ../../users.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

