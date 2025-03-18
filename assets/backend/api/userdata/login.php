<?php
session_start();
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input
    if (empty($email) || empty($password)) {
        echo "Email dan password tidak boleh kosong.";
        exit;
    }

    // Ambil user dari database
    $sql = "SELECT users.*, roles.name as role_name FROM users LEFT JOIN roles ON users.role_id = roles.id WHERE users.email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Periksa apakah pengguna ditemukan
    if ($user) {
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan session pengguna
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Periksa apakah pengguna itu admin
            if ($user['role_name'] === 'admin') {
                $_SESSION['is_admin'] = true;
                header('Location: ../../../../admin/dashboard.php'); // Redirect ke admin dashboard
                exit;
            } else {
                $_SESSION['is_admin'] = false;
                header('Location: ../../../../dashboard.php'); // Redirect ke dashboard users
                exit;
            }
        } else {
            echo "Password salah!";
            exit;
        }
    } else {
        echo "Email tidak ditemukan!";
        exit;
    }
} else {
    echo "Metode tidak valid. Gunakan POST.";
    exit;
}
?>