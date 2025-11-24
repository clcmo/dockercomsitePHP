<?php 

// Instalador do Banco de Dados MySQL usando PDO e Dotenv
// Chama o pré-requisito de base.php para carregar o dotenv e o autoload
require_once __DIR__ . '/base.php';

// Configurações do banco
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_NAME'] ?? 'db_meu_projeto';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$port = $_ENV['DB_PORT'] ?? '3306';

echo "<h1>🔧 Instalador de Banco de Dados</h1>";
echo "<hr>";

try {
    // Conecta ao MySQL sem especificar o banco
    echo "<p>📡 Conectando ao servidor MySQL...</p>";
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>✅ Conectado ao servidor MySQL!</p>";

    // Cria o banco de dados se não existir
    echo "<p>🗄️ Criando banco de dados '$db'...</p>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✅ Banco de dados criado/verificado com sucesso!</p>";

    // Seleciona o banco
    $pdo->exec("USE `$db`");

    // Criar tabela de usuários
    echo "<p>📋 Criando tabela 'usuarios'...</p>";
    $sql = "
    CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        ativo TINYINT(1) DEFAULT 1,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<p>✅ Tabela 'usuarios' criada!</p>";

    // Criar tabela de produtos (exemplo)
    echo "<p>📋 Criando tabela 'produtos'...</p>";
    $sql = "
    CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(200) NOT NULL,
        descricao TEXT,
        preco DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        estoque INT NOT NULL DEFAULT 0,
        ativo TINYINT(1) DEFAULT 1,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<p>✅ Tabela 'produtos' criada!</p>";

    // Criar tabela de categorias (exemplo)
    echo "<p>📋 Criando tabela 'categorias'...</p>";
    $sql = "
    CREATE TABLE IF NOT EXISTS categorias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descricao TEXT,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<p>✅ Tabela 'categorias' criada!</p>";

    // Inserir dados iniciais
    echo "<p>📝 Inserindo dados iniciais...</p>";
    
    // Verificar se já existem usuários
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Inserir usuário administrador
        $senhaHash = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "
        INSERT INTO usuarios (nome, email, senha) VALUES 
        ('Administrador', 'admin@example.com', :senha),
        ('João Silva', 'joao@example.com', :senha2);
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':senha' => $senhaHash,
            ':senha2' => password_hash('123456', PASSWORD_DEFAULT)
        ]);
        echo "<p>✅ Usuários criados!</p>";
        echo "<p><em>Login: admin@example.com | Senha: admin123</em></p>";
    } else {
        echo "<p>ℹ️ Usuários já existem no banco.</p>";
    }

    // Verificar se já existem categorias
    $stmt = $pdo->query("SELECT COUNT(*) FROM categorias");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $sql = "
        INSERT INTO categorias (nome, descricao) VALUES 
        ('Eletrônicos', 'Produtos eletrônicos e tecnologia'),
        ('Livros', 'Livros e publicações'),
        ('Roupas', 'Vestuário e acessórios');
        ";
        $pdo->exec($sql);
        echo "<p>✅ Categorias criadas!</p>";
    } else {
        echo "<p>ℹ️ Categorias já existem no banco.</p>";
    }

    // Verificar se já existem produtos
    $stmt = $pdo->query("SELECT COUNT(*) FROM produtos");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $sql = "
        INSERT INTO produtos (nome, descricao, preco, estoque) VALUES 
        ('Notebook Dell', 'Notebook com 8GB RAM e SSD 256GB', 2999.90, 10),
        ('Mouse Logitech', 'Mouse sem fio ergonômico', 89.90, 50),
        ('Teclado Mecânico', 'Teclado mecânico RGB', 299.90, 25);
        ";
        $pdo->exec($sql);
        echo "<p>✅ Produtos criados!</p>";
    } else {
        echo "<p>ℹ️ Produtos já existem no banco.</p>";
    }

    echo "<hr>";
    echo "<h2>✅ Instalação concluída com sucesso!</h2>";
    echo "<p><strong>Informações do banco:</strong></p>";
    echo "<ul>";
    echo "<li><strong>Host:</strong> $host</li>";
    echo "<li><strong>Porta:</strong> $port</li>";
    echo "<li><strong>Banco:</strong> $db</li>";
    echo "<li><strong>Usuário:</strong> $user</li>";
    echo "</ul>";
    echo "<p><a href='index.php'>← Voltar para a página inicial</a></p>";

} catch (Exception $e) {
    echo "<h2>❌ Erro durante a instalação:</h2>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
    echo "<hr>";
    echo "<h3>💡 Possíveis soluções:</h3>";
    echo "<ul>";
    echo "<li>Verifique se o MySQL está rodando</li>";
    echo "<li>Confirme o usuário e senha no arquivo .env</li>";
    echo "<li>Verifique se o usuário tem permissão para criar bancos de dados</li>";
    echo "<li>Tente usar senha vazia se estiver usando XAMPP/WAMP</li>";
    echo "</ul>";
}