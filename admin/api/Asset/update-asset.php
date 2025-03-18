<?php
session_start();
require_once '../../../assets/backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nama = $_POST['nama_asset'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tanggal_pengadaan = $_POST['tanggal_pengadaan'] ?? '';
    $harga = $_POST['harga'] ?? '';
    $status = $_POST['status'] ?? '';
    
    // Validate inputs
    if (empty($id) || empty($nama) || empty($kategori) || empty($tanggal_pengadaan) || empty($harga) || empty($status)) {
        echo "All fields are required";
        exit;
    }
    
    try {
        $stmt = $conn->prepare("UPDATE asset SET nama_asset = ?, kategori = ?, tanggal_pengadaan = ?, harga = ?, status = ? WHERE id = ?");
        $stmt->execute([$nama, $kategori, $tanggal_pengadaan, $harga, $status, $id]);
        header('Location: ../../assets.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

