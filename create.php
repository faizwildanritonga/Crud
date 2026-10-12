<?php
require __DIR__ . '/config/Database.php';
require __DIR__ . '/includes/header.php';

$pdo = Database::getInstance()->getConnection();
$kategoriList = $pdo->query("SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori")->fetchAll();
$supplierList = $pdo->query("SELECT id_supplier, nama_supplier FROM supplier ORDER BY nama_supplier")->fetchAll();
?>

<h1>Tambah Produk</h1>

<form class="form-card" method="post" action="/tugas8/store.php">
  <div class="form-group">
    <label for="nama_produk">Nama Produk</label>
    <input type="text" id="nama_produk" name="nama_produk" required maxlength="100">
  </div>

  <div class="form-group">
    <label for="id_kategori">Kategori</label>
    <select id="id_kategori" name="id_kategori" required>
      <option value="">-- Pilih Kategori --</option>
      <?php foreach ($kategoriList as $k): ?>
        <option value="<?= (int)$k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="id_supplier">Supplier</label>
    <select id="id_supplier" name="id_supplier" required>
      <option value="">-- Pilih Supplier --</option>
      <?php foreach ($supplierList as $s): ?>
        <option value="<?= (int)$s['id_supplier'] ?>"><?= htmlspecialchars($s['nama_supplier']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="harga">Harga (Rp)</label>
      <input type="number" id="harga" name="harga" min="0" step="100" required>
    </div>
    <div class="form-group">
      <label for="stok">Stok</label>
      <input type="number" id="stok" name="stok" min="0" required>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit">Simpan Produk</button>
    <a class="btn-cancel" href="/tugas8/index.php">Batal</a>
  </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
