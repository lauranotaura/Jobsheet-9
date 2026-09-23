<?php
session_start();
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Anggota Baru</h2>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </div>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <p>
            <label for="nim">NIM</label><br>
            <input type="text" id="nim" name="nim" required>
        </p>

        <p>
            <label for="nama">Nama Lengkap</label><br>
            <input type="text" id="nama" name="nama" required>
        </p>

        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required>
        </p>

        <p>
            <label for="telepon">Nomor Telepon</label><br>
            <input type="text" id="telepon" name="telepon" required>
        </p>

        <p>
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="list.php" class="btn-secondary">Batal</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>