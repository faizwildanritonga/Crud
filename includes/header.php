<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD Inventaris — Tugas Rutin 8</title>
<link rel="stylesheet" href="/tugas8/assets/css/style.css">
</head>
<body>
<header class="topbar">
  <div class="container topbar-inner">
    <a href="/tugas8/index.php" class="brand">📦 Inventaris</a>
    <nav>
      <a href="/tugas8/index.php">Daftar Produk</a>
      <a href="/tugas8/create.php">+ Tambah Produk</a>
    </nav>
  </div>
</header>
<main class="container">
<?php require __DIR__ . '/flash.php'; show_flash(); ?>
