<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;

if (!$id) {
    header('Location: list.php');
    exit;
}

$nim     = trim($_POST['nim'] ?? '');
$nama    = trim($_POST['nama'] ?? '');
$email   = trim($_POST['email'] ?? '');
$telepon = trim($_POST['telepon'] ?? '');

if ($nim === '' || $nama === '' || $email === '' || $telepon === '') {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Semua kolom wajib diisi!'];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE anggota SET 
        nim = :nim, 
        nama = :nama, 
        email = :email, 
        telepon = :telepon 
     WHERE id = :id"
);

$stmt->execute([
    'nim'     => $nim,
    'nama'    => $nama,
    'email'   => $email,
    'telepon' => $telepon,
    'id'      => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data anggota berhasil diperbarui.'];
header('Location: list.php');
exit;