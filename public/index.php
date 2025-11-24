<?php

// Incluir a classe de conexão
require_once __DIR__ . '/conn.php';

// Chama o recurso Database
use App\Core\Database as data;

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
    $db = new data();
    
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
    
    // Exemplo: Buscar dados do banco
    echo "<h3>👥 Usuários Cadastrados:</h3>";
    $stmt = $db->getConnection()->query("SELECT id, nome, email, criado_em FROM usuarios");
    $usuarios = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
    if (count($usuarios) > 0) {
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>ID</th><th>Nome</th><th>Email</th><th>Criado em</th>";
        echo "</tr>";
        foreach ($usuarios as $usuario) {
            echo "<tr>";
            echo "<td>{$usuario['id']}</td>";
            echo "<td>{$usuario['nome']}</td>";
            echo "<td>{$usuario['email']}</td>";
            echo "<td>{$usuario['criado_em']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum usuário cadastrado.</p>";
    }
    
    echo "<hr>";
    echo "<p><a href='install.php'>🔧 Reinstalar banco de dados</a></p>";
    
} catch (\Exception $e) {
    echo "<h2>❌ Erro: " . $e->getMessage() . "</h2>";
    echo "<p>Parece que o banco de dados não está configurado corretamente.</p>";
    echo "<p><a href='install.php' style='display: inline-block; padding: 10px 20px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;'>🔧 Executar Instalador</a></p>";
}