<?php
include 'config.php'; // Sertakan file koneksi.php

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Ambil data akun berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Akun tidak ditemukan.";
        exit;
    }
} else {
    echo "ID akun tidak diberikan.";
    exit;
}

// Proses form edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];

    $updateStmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?");
    $updateStmt->bind_param("ssi", $newUsername, $newEmail, $userId);

    if ($updateStmt->execute()) {
        header("Location: index.php"); // Redirect kembali ke halaman utama setelah mengedit
        exit;
    } else {
        echo "Gagal mengedit akun.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun</title>
</head>
<body>
    <h2>Edit Akun</h2>
    <form method="POST" action="">
        <label for="new_username">Username Baru: </label>
        <input type="text" name="new_username" value="<?php echo $row['username']; ?>" required><br>

        <label for="new_email">Email Baru: </label>
        <input type="email" name="new_email" value="<?php echo $row['email']; ?>" required><br>

        <input type="submit" value="Simpan Perubahan">
    </form>
</body>
</html>
