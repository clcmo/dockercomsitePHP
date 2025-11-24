<?php

// Require_Once pedirá pra que seja carregado o autoload do Composer, o Dotenv e as classes necessárias
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/view/user.php';
require_once __DIR__ . '/controller/user.php';

// Chama o recurso Database e da View do Usuario
use App\Core\Database as data;
use Views\UserView;

/**
 * Verifica se o banco de dados está instalado
 */
function isDatabaseInstalled($connection) {
    try {
        // Verifica se a tabela 'usuarios' existe
        $stmt = $connection->query("SHOW TABLES LIKE 'usuarios'");
        return $stmt->rowCount() > 0;
    } catch (\Exception $e) {
        return false;
    }
}


// Tenta conectar e verificar o estado do banco
try {
    $db = new data(); // instancia a conexão com o banco de dados
    
    if (!$db->isConnected()) {
        echo "<h2>❌ Falha na conexão com o banco de dados.</h2>";
        echo "<p><a href='install.php' style='display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>🔧 Executar Instalador</a></p>";
        exit;
    }
    
    // Verifica se o banco está instalado
    if (!isDatabaseInstalled($db->getConnection())) {
        echo "<h2>⚠️ Banco de dados não instalado!</h2>";
        echo "<p>É necessário executar o instalador antes de usar o sistema.</p>";
        echo "<p><a href='install.php' style='display: inline-block; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>🔧 Ir para o Instalador</a></p>";
        exit;
    }
    
    // Se chegou aqui, o banco está instalado e funcionando
    echo "<h2>✅ Sistema pronto para uso!</h2>";
    echo "<p>Banco de dados instalado e conexão estabelecida com sucesso.</p>";
    
    $info = $db->getConnectionInfo();
    echo "<h3>📊 Informações da Conexão:</h3>";
    echo "<ul>";
    foreach ($info as $key => $value) {
        echo "<li><strong>" . ucfirst($key) . ":</strong> $value</li>";
    }
    echo "</ul>";

    // Prepara a viewModel (callable) — tenta usar Controller\UserController se existir, senão usa query direta
    $viewModel = function($pdo) {
        // usar controller se disponível
        if (class_exists('\Controller\UserController')) {
            try {
                $controller = new \Controller\UserController($pdo);
                return $controller->listUsers($pdo);
            } catch (\Throwable $e) {
                // fallback para query direta
                try {
                    $stmt = $pdo->query("SELECT id, nome, email, criado_em FROM usuarios");
                    return $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
                } catch (\Exception $e) {
                    return [];
                }
            }
        }
    };
    
    // Exemplo: Buscar dados do banco via UserView
    echo "<h3>👥 Usuários Cadastrados (via UserView):</h3>";
    $userView = new UserView($db->getConnection(), $viewModel);
    $userView->getAllUsers();
    
    echo "<hr>";
    echo "<p><a href='install.php'>🔧 Reinstalar banco de dados</a></p>";
    
} catch (\Exception $e) {
    echo "<h2>❌ Erro: " . $e->getMessage() . "</h2>";
    echo "<p>Parece que o banco de dados não está configurado corretamente.</p>";
    echo "<p><a href='install.php' style='display: inline-block; padding: 10px 20px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;'>🔧 Executar Instalador</a></p>";
}