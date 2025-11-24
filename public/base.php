<?php 

// Aqui colocamos os pré requisitos para carregar nosso projeto, o dotenv e o autoload do Composer

// Carregar autoload do Composer
$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    echo "<h2>❌ vendor/autoload.php não encontrado. Rode <code>composer install</code> na raiz do projeto.</h2>";
    exit;
}
require_once $autoload;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();