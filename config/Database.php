<?php
/**
 * Koneksi database dengan Singleton pattern.
 * Hanya satu instance PDO yang dibuat selama request berjalan.
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private const HOST = 'localhost';
    private const DB_NAME = 'inventaris_db';
    private const USER = 'root';
    private const PASS = '';

    // Constructor private -> tidak bisa di-instantiate dari luar class
    private function __construct()
    {
        $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, self::USER, self::PASS, $options);
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . $e->getMessage());
        }
    }

    // Cegah object di-clone
    private function __clone() {}

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
