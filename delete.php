<?php
include 'config.php'; // Sertakan file koneksi.php

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Hapus data akun berdasarkan ID
    $stmt = $conn->prepare("DELETE FROM tbl_users WHERE id=?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect kembali ke halaman utama setelah menghapus
        exit;
    } else {
        echo "Gagal menghapus akun.";
        exit;
    }
} else {
    echo "ID akun tidak diberikan.";
    exit;
}
?>
