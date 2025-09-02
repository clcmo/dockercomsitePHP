<?php 

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class Database {

    private $host;
    private $db;
    private $user;
    private $pass;
    private $port;
    private $connection;

    public function __construct() {

        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->db   = $_ENV['DB_NAME'] ?? 'db_meu_projeto';
        $this->user = $_ENV['DB_USER'] ?? 'root';
        $this->pass = $_ENV['DB_PASS'] ?? 'root';
        $this->port = $_ENV['DB_PORT'] ?? '3306';

        try {
            $this->connection = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->db", $this->user, $this->pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->connection = null;
            throw new Exception("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function isConnected() {
        return $this->connection !== null;
    }

    public function getConnectionInfo() {
        return [
            'host' => $this->host,
            'database' => $this->db,
            'user' => $this->user,
            'port' => $this->port
        ];
    }
}
