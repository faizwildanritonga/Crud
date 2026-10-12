-- =========================================================
-- Tugas Rutin 8 — CRUD Inventaris
-- Jalankan file ini di phpMyAdmin (tab Import) atau via CLI:
--   mysql -u root -p < inventaris_db.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS inventaris_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE inventaris_db;

-- ---------------------------------------------------------
-- Tabel kategori
-- ---------------------------------------------------------
DROP TABLE IF EXISTS produk;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS supplier;

CREATE TABLE kategori (
  id_kategori   INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabel supplier
-- ---------------------------------------------------------
CREATE TABLE supplier (
  id_supplier   INT AUTO_INCREMENT PRIMARY KEY,
  nama_supplier VARCHAR(100) NOT NULL,
  telepon       VARCHAR(20)  NOT NULL,
  alamat        VARCHAR(150) NOT NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabel produk (FK ke kategori & supplier)
-- ---------------------------------------------------------
CREATE TABLE produk (
  id_produk     INT AUTO_INCREMENT PRIMARY KEY,
  nama_produk   VARCHAR(100) NOT NULL,
  id_kategori   INT NOT NULL,
  id_supplier   INT NOT NULL,
  harga         DECIMAL(12,2) NOT NULL DEFAULT 0,
  stok          INT NOT NULL DEFAULT 0,
  dibuat_pada   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_produk_kategori FOREIGN KEY (id_kategori)
    REFERENCES kategori(id_kategori) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_produk_supplier FOREIGN KEY (id_supplier)
    REFERENCES supplier(id_supplier) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Seed data (masing-masing >= 5 baris)
-- ---------------------------------------------------------
-- ---------------------------------------------------------
-- Tabel log_aktivitas (bonus: log transaksi delete)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS log_aktivitas;
CREATE TABLE log_aktivitas (
  id_log      INT AUTO_INCREMENT PRIMARY KEY,
  aksi        VARCHAR(20) NOT NULL,
  keterangan  VARCHAR(255) NOT NULL,
  dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO kategori (nama_kategori) VALUES
  ('Alat Tulis'),
  ('Elektronik'),
  ('Perlengkapan Dapur'),
  ('Perlengkapan Kantor'),
  ('Kebersihan');

INSERT INTO supplier (nama_supplier, telepon, alamat) VALUES
  ('CV Sumber Makmur',    '0812-1111-2222', 'Jl. Merdeka No. 10, Medan'),
  ('PT Cahaya Elektronik','0813-3333-4444', 'Jl. Gatot Subroto No. 25, Medan'),
  ('UD Rejeki Dapur',     '0821-5555-6666', 'Jl. Setia Budi No. 7, Medan'),
  ('CV Kantor Jaya',      '0852-7777-8888', 'Jl. Sisingamangaraja No. 3, Medan'),
  ('PT Bersih Sejahtera', '0877-9999-0000', 'Jl. Iskandar Muda No. 15, Medan');

INSERT INTO produk (nama_produk, id_kategori, id_supplier, harga, stok) VALUES
  ('Pulpen Pilot G2',          1, 1, 8500,   120),
  ('Buku Tulis 58 Lembar',     1, 1, 4000,   200),
  ('Kabel HDMI 2M',            2, 2, 45000,  35),
  ('Lampu LED 12W',            2, 2, 27000,  60),
  ('Panci Stainless 24cm',     3, 3, 125000, 18),
  ('Teflon Anti Lengket',      3, 3, 95000,  22),
  ('Map Plastik Folio',        4, 4, 3500,   150),
  ('Stapler Besar',            4, 4, 22000,  40),
  ('Sabun Cuci Tangan 500ml',  5, 5, 15000,  70),
  ('Pel Lantai Microfiber',    5, 5, 32000,  25);
