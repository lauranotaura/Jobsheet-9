<?php
session_start();
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Konfigurasi Pagination & Pencarian
$perPage = 5;
$page    = max(1, (int) ($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

// Pengambilan Data dengan Query Kondisional
if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<section>
    <h2>Daftar Buku</h2>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </div>
    <?php endif; ?>

    <!-- Form Pencarian (Method GET) -->
    <form method="get" action="list.php" class="search-form">
        <p>
            <label for="search-input">Cari Judul Buku:</label>
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik judul buku...">
            <button type="submit">Cari</button>
            <?php if ($keyword !== ''): ?>
                <a href="list.php">Reset</a>
            <?php endif; ?>
        </p>
    </form>

    <p><a href="tambah.php" class="btn-primary">Tambah Buku Baru</a></p>

    <!-- Tabel Data Buku -->
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Tahun</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarBuku)): ?>
                <tr>
                    <td colspan="6" align="center">Data tidak ditemukan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($daftarBuku as $buku): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                        <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                        <td><?php echo htmlspecialchars($buku['tahun']); ?></td>
                        <td><?php echo htmlspecialchars($buku['kategori']); ?></td>
                        <td><?php echo htmlspecialchars($buku['stok']); ?></td>
                        <td>
                            <!-- Tombol Edit (Tautan biasa / GET) -->
                            <a href="edit.php?id=<?php echo $buku['id']; ?>" class="btn-edit">Edit</a>

                            <!-- Tombol Hapus (Wajib berbentuk Form / POST) -->
                            <form class="form-hapus" method="post" action="hapus.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                                <button type="submit" class="btn-hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Navigasi Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination" style="margin-top: 15px;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>" 
                   style="<?php echo $i === $page ? 'font-weight:bold; text-decoration:underline;' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>