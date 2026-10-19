<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $config = require __DIR__ . '/db_config.php';
        $this->host = $config['db_host'];
        $this->db_name = $config['db_name'];
        $this->username = $config['db_user'];
        $this->password = $config['db_pass'];
    }

    public function getConnection() {
        $this->conn = null;
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ];

        for ($attempt = 1; $attempt <= 2; $attempt++) {
            try {
                $this->conn = new PDO($dsn, $this->username, $this->password, $options);
                $this->conn->exec("set names utf8");
                return $this->conn;
            } catch(PDOException $exception) {
                error_log("Database connection attempt {$attempt} failed: " . $exception->getMessage());
                if ($attempt === 1) {
                    usleep(150000); // 150ms retry delay
                }
            }
        }
        return null;
    }
}
?>