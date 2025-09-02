<?php 

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class Database {

    private $host;
    private $db;
    private $user;
    private $pass;

    private $port;

    public function __construct() {

        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->db   = $_ENV['DB_NAME'] ?? 'db_meu_projeto';
        $this->user = $_ENV['DB_USER'] ?? 'root';
        $this->pass = $_ENV['DB_PASS'] ?? 'root';
        $this->port = $_ENV['DB_PORT'] ?? '3306';

        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexão bem-sucedida!";
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }
}
