<?php 
    require 'conn.php';

    $db = new Database();

    if($db){
        echo "Conexão estabelecida com sucesso!";
    } else {
        echo "Falha na conexão.";
    }
?>