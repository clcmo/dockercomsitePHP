<?php 
    require 'conn.php';

    if($conn){
        echo "Conexão estabelecida com sucesso!";
    } else {
        echo "Falha na conexão.";
    }
?>