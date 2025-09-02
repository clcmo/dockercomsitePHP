## Passo a Passo Completo do Projeto PHP com Docker

1. Criação da Estrutura Inicial

```
Projeto/
├── public/           <- Diretório público da aplicação
├── workflow/         <- Configurações do Docker Compose
├── composer.json     <- Dependências PHP
├── Dockerfile        <- Configuração da imagem Docker
└── .env             <- Variáveis de ambiente
```

2. Configuração das Dependências (composer.json)

* Definida dependência do vlucas/phpdotenv para gerenciar variáveis de ambiente
* Permite carregar configurações do arquivo

3. Criação do Arquivo de Conexão (public/conn.php)

* Carregamento do autoloader: require __DIR__ . '/vendor/autoload.php'; (no localhost, pelo replit, terá que add os ../)
* Inicialização do dotenv: Para carregar variáveis do arquivo
* Classe Database: Gerencia conexão PDO com MySQL
* Configuração flexível: Usa variáveis de ambiente com fallbacks padrão

4. Página Principal (public/index.php)

* Importa conn.php: Acessa a classe Database
* Testa conexão: Verifica se MySQL está acessível
* Exibe informações: Host, porta, banco, usuário, versão do MySQL
* Tratamento de erros: Mostra mensagens claras em caso de falha

5. Configuração do Docker (Dockerfile)

* Base: PHP 8.2 com Apache
* Extensões: PDO, PDO MySQL, MySQLi, ZIP
* Composer: Instalação e execução das dependências
* Estrutura:
    * Copia e Executa composer install
    * Copia arquivos do projeto
    * Define permissões corretas

6. Orquestração com Docker Compose (workflow/docker-compose.yaml)

* Serviço MySQL:
    * Imagem: MySQL 8.0
    * Porta: 3308 externa → 3306 interna
    * Variáveis de ambiente do Volume persistente para dados

* Serviço App:
    * Build do Dockerfile
    * Dependência do MySQL
    * Porta: 8000 externa
    * Carrega arquivo 

7. Resolução do Problema do Autoload

* Problema identificado: Caminho incorreto: Vendor real estava na raiz:

Solução aplicada:

```
// Antes (apenas local)
require __DIR__ . '/vendor/autoload.php';

// Depois (para externo)
require __DIR__ . '/../vendor/autoload.php';

```

8. Configuração do Replit (.replit)

* Workflow PHP Server: Executa servidor de desenvolvimento
* Comando: php -S 0.0.0.0:5000 -t public/
* Porta: 5000 mapeada para 80 em produção
* Deploy: Configurado para usar Docker

9. Fluxo de Funcionamento

* Desenvolvimento: Servidor PHP nativo na porta 5000
* Produção: Container Docker com Apache na porta 80
* Banco de dados: MySQL em container separado
* Variáveis: Carregadas do via phpdotenv

10. Compatibilidade Garantida

* Local: Funciona com Docker Compose
* Replit: Funciona com servidor PHP nativo
* Deploy: Funciona com containers Docker
* Paths: Relativos, funcionam em qualquer ambiente

Este setup garante que a aplicação rode consistentemente em diferentes ambientes, com configuração flexível via variáveis de ambiente e estrutura de arquivos bem organizada.
