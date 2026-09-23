<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$nim     = trim($_POST['nim'] ?? '');
$nama    = trim($_POST['nama'] ?? '');
$email   = trim($_POST['email'] ?? '');
$telepon = trim($_POST['telepon'] ?? '');

if ($nim === '' || $nama === '' || $email === '' || $telepon === '') {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Semua kolom wajib diisi!'];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO anggota (nim, nama, email, telepon) 
     VALUES (:nim, :nama, :email, :telepon)"
);

$stmt->execute([
    'nim'     => $nim,
    'nama'    => $nama,
    'email'   => $email,
    'telepon' => $telepon,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;