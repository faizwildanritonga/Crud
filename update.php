<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/config/Database.php';
require __DIR__ . '/includes/flash.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /tugas8/index.php');
    exit;
}

$idProduk   = (int)($_POST['id_produk'] ?? 0);
$namaProduk = trim($_POST['nama_produk'] ?? '');
$idKategori = (int)($_POST['id_kategori'] ?? 0);
$idSupplier = (int)($_POST['id_supplier'] ?? 0);
$harga      = (float)($_POST['harga'] ?? 0);
$stok       = (int)($_POST['stok'] ?? 0);

if ($idProduk <= 0 || $namaProduk === '' || $idKategori <= 0 || $idSupplier <= 0 || $harga < 0 || $stok < 0) {
    set_flash('gagal', 'Data tidak valid, update dibatalkan.');
    header('Location: /tugas8/index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();

try {
    $sql = "UPDATE produk
            SET nama_produk = :nama, id_kategori = :kategori, id_supplier = :supplier,
                harga = :harga, stok = :stok
            WHERE id_produk = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nama'     => $namaProduk,
        'kategori' => $idKategori,
        'supplier' => $idSupplier,
        'harga'    => $harga,
        'stok'     => $stok,
        'id'       => $idProduk,
    ]);

    set_flash('sukses', 'Produk "' . $namaProduk . '" berhasil diperbarui.');
} catch (PDOException $e) {
    set_flash('gagal', 'Gagal memperbarui produk: ' . $e->getMessage());
}

header('Location: /tugas8/index.php');
exit;
