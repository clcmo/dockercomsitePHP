<?php
// Declaração de namespace para a classe Database
namespace App\Core;

require_once 'base.php';

// Uso das globais de PDO e Exception
use PDO;
use Exception;

class Database
{

    private $host;
    private $db;
    private $user;
    private $pass;
    private $port;
    private $connection;

    public function __construct()
    {

        $this->host = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'mysql');
        $this->port = getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? '3308');
        $this->db = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'db_meu_projeto');
        $this->user = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root');
        $this->pass = getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? 'root');
        
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->user, $this->pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->connection = null;
            throw new Exception("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function isConnected()
    {
        return $this->connection !== null;
    }

    public function getConnectionInfo()
    {
        return [
            'host' => $this->host,
            'database' => $this->db,
            'user' => $this->user,
            'port' => $this->port
        ];
    }
}
