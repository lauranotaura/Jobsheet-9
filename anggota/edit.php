<?php
session_start();
$page_title = "Edit Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    header('Location: list.php');
    exit;
}
?>

<section>
    <h2>Edit Anggota</h2>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </div>
    <?php endif; ?>

    <form id="form-edit" method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($anggota['id']); ?>">

        <p>
            <label for="nim">NIM</label><br>
            <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($anggota['nim']); ?>" required>
        </p>

        <p>
            <label for="nama">Nama Lengkap</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($anggota['nama']); ?>" required>
        </p>

        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($anggota['email']); ?>" required>
        </p>

        <p>
            <label for="telepon">Nomor Telepon</label><br>
            <input type="text" id="telepon" name="telepon" value="<?php echo htmlspecialchars($anggota['telepon']); ?>" required>
        </p>

        <p>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="list.php" class="btn-secondary">Batal</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>