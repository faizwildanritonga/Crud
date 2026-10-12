<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/config/Database.php';
require __DIR__ . '/includes/flash.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /tugas8/index.php');
    exit;
}

$namaProduk = trim($_POST['nama_produk'] ?? '');
$idKategori = (int)($_POST['id_kategori'] ?? 0);
$idSupplier = (int)($_POST['id_supplier'] ?? 0);
$harga      = (float)($_POST['harga'] ?? 0);
$stok       = (int)($_POST['stok'] ?? 0);

if ($namaProduk === '' || $idKategori <= 0 || $idSupplier <= 0 || $harga < 0 || $stok < 0) {
    set_flash('gagal', 'Semua field wajib diisi dengan benar.');
    header('Location: /tugas8/create.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();

try {
    $sql = "INSERT INTO produk (nama_produk, id_kategori, id_supplier, harga, stok)
            VALUES (:nama, :kategori, :supplier, :harga, :stok)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nama'     => $namaProduk,
        'kategori' => $idKategori,
        'supplier' => $idSupplier,
        'harga'    => $harga,
        'stok'     => $stok,
    ]);

    set_flash('sukses', 'Produk "' . $namaProduk . '" berhasil ditambahkan.');
} catch (PDOException $e) {
    set_flash('gagal', 'Gagal menyimpan produk: ' . $e->getMessage());
}

header('Location: /tugas8/index.php');
exit;
