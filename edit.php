<?php
require __DIR__ . '/config/Database.php';
require __DIR__ . '/includes/flash.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    set_flash('gagal', 'ID produk tidak valid.');
    header('Location: /tugas8/index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();

$stmt = $pdo->prepare("SELECT * FROM produk WHERE id_produk = :id");
$stmt->execute(['id' => $id]);
$produk = $stmt->fetch();

if (!$produk) {
    set_flash('gagal', 'Produk tidak ditemukan.');
    header('Location: /tugas8/index.php');
    exit;
}

$kategoriList = $pdo->query("SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori")->fetchAll();
$supplierList = $pdo->query("SELECT id_supplier, nama_supplier FROM supplier ORDER BY nama_supplier")->fetchAll();

require __DIR__ . '/includes/header.php';
?>

<h1>Edit Produk</h1>

<form class="form-card" method="post" action="/tugas8/update.php">
  <input type="hidden" name="id_produk" value="<?= (int)$produk['id_produk'] ?>">

  <div class="form-group">
    <label for="nama_produk">Nama Produk</label>
    <input type="text" id="nama_produk" name="nama_produk" required maxlength="100"
           value="<?= htmlspecialchars($produk['nama_produk']) ?>">
  </div>

  <div class="form-group">
    <label for="id_kategori">Kategori</label>
    <select id="id_kategori" name="id_kategori" required>
      <?php foreach ($kategoriList as $k): ?>
        <option value="<?= (int)$k['id_kategori'] ?>" <?= $k['id_kategori'] == $produk['id_kategori'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($k['nama_kategori']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="id_supplier">Supplier</label>
    <select id="id_supplier" name="id_supplier" required>
      <?php foreach ($supplierList as $s): ?>
        <option value="<?= (int)$s['id_supplier'] ?>" <?= $s['id_supplier'] == $produk['id_supplier'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($s['nama_supplier']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="harga">Harga (Rp)</label>
      <input type="number" id="harga" name="harga" min="0" step="100" required
             value="<?= (float)$produk['harga'] ?>">
    </div>
    <div class="form-group">
      <label for="stok">Stok</label>
      <input type="number" id="stok" name="stok" min="0" required
             value="<?= (int)$produk['stok'] ?>">
    </div>
  </div>

  <div class="form-actions">
    <button type="submit">Update Produk</button>
    <a class="btn-cancel" href="/tugas8/index.php">Batal</a>
  </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
