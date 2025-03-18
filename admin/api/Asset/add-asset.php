<?php
session_start();
require_once '../../../assets/backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_asset'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tanggal_pengadaan = $_POST['tanggal_pengadaan'] ?? '';
    $harga = $_POST['harga'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validate input
    if (empty($nama) || empty($kategori) || empty($tanggal_pengadaan) || empty($harga) || empty($status)) {
        echo "All fields are required";
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO asset (nama_asset, kategori, tanggal_pengadaan, harga, status) VALUES (:nama, :kategori, :tanggal_pengadaan, :harga, :status)");
        $stmt->execute([
            'nama'=> $nama,
            'kategori' => $kategori, 
            'tanggal_pengadaan' => $tanggal_pengadaan, 
            'harga' => $harga, 
            'status' => $status
        ]);
        header('Location: ../../assets.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
