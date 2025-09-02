<?php 
    require 'conn.php';

    try {
        $db = new Database();
        
        if($db->isConnected()){
            echo "<h2>✅ Conexão estabelecida com sucesso!</h2>";
            
            $info = $db->getConnectionInfo();
            echo "<h3>Detalhes da conexão:</h3>";
            echo "<ul>";
            echo "<li><strong>Host:</strong> " . $info['host'] . "</li>";
            echo "<li><strong>Porta:</strong> " . $info['port'] . "</li>";
            echo "<li><strong>Banco:</strong> " . $info['database'] . "</li>";
            echo "<li><strong>Usuário:</strong> " . $info['user'] . "</li>";
            echo "</ul>";
            
            // Teste simples de query
            $conn = $db->getConnection();
            $stmt = $conn->query("SELECT VERSION() as version");
            $version = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p><strong>Versão do MySQL:</strong> " . $version['version'] . "</p>";
            
        } else {
            echo "<h2>❌ Falha na conexão.</h2>";
        }
    } catch (Exception $e) {
        echo "<h2>❌ Erro na conexão:</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
        
        echo "<h3>Verifique:</h3>";
        echo "<ul>";
        echo "<li>Se o arquivo .env existe na raiz do projeto</li>";
        echo "<li>Se as variáveis DB_HOST, DB_NAME, DB_USER, DB_PASS estão configuradas</li>";
        echo "<li>Se o container MySQL está rodando</li>";
        echo "</ul>";
    }
?>