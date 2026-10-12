<?php
require __DIR__ . '/config/Database.php';
require __DIR__ . '/includes/header.php';

$pdo = Database::getInstance()->getConnection();

// ---------- Fitur pencarian (bonus) ----------
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $sql = "SELECT p.id_produk, p.nama_produk, p.harga, p.stok,
                   k.nama_kategori, s.nama_supplier
            FROM produk p
            JOIN kategori k ON k.id_kategori = p.id_kategori
            JOIN supplier s ON s.id_supplier = p.id_supplier
            WHERE p.nama_produk LIKE :kw
            ORDER BY p.id_produk DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['kw' => '%' . $keyword . '%']);
} else {
    $sql = "SELECT p.id_produk, p.nama_produk, p.harga, p.stok,
                   k.nama_kategori, s.nama_supplier
            FROM produk p
            JOIN kategori k ON k.id_kategori = p.id_kategori
            JOIN supplier s ON s.id_supplier = p.id_supplier
            ORDER BY p.id_produk DESC";
    $stmt = $pdo->query($sql);
}

$produkList = $stmt->fetchAll();
?>

<div class="page-head">
  <h1>Daftar Produk</h1>
  <form class="search-form" method="get" action="/tugas8/index.php">
    <input type="text" name="q" placeholder="Cari nama produk..." value="<?= htmlspecialchars($keyword) ?>">
    <button type="submit">Cari</button>
    <?php if ($keyword !== ''): ?>
      <a class="btn-reset" href="/tugas8/index.php">Reset</a>
    <?php endif; ?>
  </form>
</div>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Supplier</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($produkList)): ?>
        <tr><td colspan="7" class="empty">Belum ada data produk.</td></tr>
      <?php else: ?>
        <?php foreach ($produkList as $i => $p): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($p['nama_produk']) ?></td>
            <td><?= htmlspecialchars($p['nama_kategori']) ?></td>
            <td><?= htmlspecialchars($p['nama_supplier']) ?></td>
            <td>Rp <?= number_format((float)$p['harga'], 0, ',', '.') ?></td>
            <td><?= (int)$p['stok'] ?></td>
            <td class="actions">
              <a class="btn-edit" href="/tugas8/edit.php?id=<?= (int)$p['id_produk'] ?>">Edit</a>
              <a class="btn-delete" href="/tugas8/delete.php?id=<?= (int)$p['id_produk'] ?>"
                 onclick="return confirm('Yakin hapus produk ini?');">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
