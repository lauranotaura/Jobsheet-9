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

$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = trim($_POST['tahun'] ?? '');
$isbn      = trim($_POST['isbn'] ?? '');
$stok       = trim($_POST['stok'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');

if ($judul === '' || $pengarang === '' || $tahun === '' || $isbn === '' || $stok === '') {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Semua kolom wajib diisi!'];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE buku SET 
        judul = :judul, 
        pengarang = :pengarang, 
        tahun = :tahun, 
        isbn = :isbn, 
        stok = :stok, 
        kategori = :kategori 
     WHERE id = :id"
);

$stmt->execute([
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'isbn'      => $isbn,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
    'id'        => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data buku berhasil diperbarui.'];
header('Location: list.php');
exit;