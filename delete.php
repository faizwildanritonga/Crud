<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/config/Database.php';
require __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    set_flash('gagal', 'ID produk tidak valid.');
    header('Location: /tugas8/index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();

try {
    $pdo->beginTransaction();

    // Ambil dulu nama produk untuk keperluan log
    $stmt = $pdo->prepare("SELECT nama_produk FROM produk WHERE id_produk = :id");
    $stmt->execute(['id' => $id]);
    $produk = $stmt->fetch();

    if (!$produk) {
        $pdo->rollBack();
        set_flash('gagal', 'Produk tidak ditemukan.');
        header('Location: /tugas8/index.php');
        exit;
    }

    $del = $pdo->prepare("DELETE FROM produk WHERE id_produk = :id");
    $del->execute(['id' => $id]);

    // Bonus: catat log aktivitas delete dalam transaction yang sama
    $log = $pdo->prepare("INSERT INTO log_aktivitas (aksi, keterangan) VALUES ('hapus', :ket)");
    $log->execute(['ket' => 'Menghapus produk "' . $produk['nama_produk'] . '" (ID ' . $id . ')']);

    $pdo->commit();
    set_flash('sukses', 'Produk "' . $produk['nama_produk'] . '" berhasil dihapus.');
} catch (PDOException $e) {
    $pdo->rollBack();
    set_flash('gagal', 'Gagal menghapus produk: ' . $e->getMessage());
}

header('Location: /tugas8/index.php');
exit;
