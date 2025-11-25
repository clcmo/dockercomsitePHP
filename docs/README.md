# Projeto de Servidor Docker com Sistema Web em PHP

[![GitHub license](https://img.shields.io/github/license/clcmo/dockercomsitePHP?style=for-the-badge)](https://github.com/clcmo/dockercomsitePHP)
[![GitHub stars](https://img.shields.io/github/stars/clcmo/dockercomsitePHP?style=for-the-badge)](https://github.com/clcmo/dockercomsitePHP/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/clcmo/dockercomsitePHP?style=for-the-badge)](https://github.com/clcmo/dockercomsitePHP/network)
[![GitHub issues](https://img.shields.io/github/issues/clcmo/dockercomsitePHP?style=for-the-badge)](https://github.com/clcmo/dockercomsitePHP/issues)
[![GitHub donate](https://img.shields.io/github/sponsors/clcmo?color=pink&style=for-the-badge)](https://github.com/sponsors/clcmo)


## 🐳 Docker + PHP + MySQL

Projeto demonstrativo de uma aplicação PHP conectada ao MySQL utilizando Docker e Docker Compose, com suporte para múltiplos ambientes (local, Replit, deploy).

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Tecnologias](#tecnologias)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Uso](#uso)
- [Configuração](#configuração)
- [Deploy](#deploy)
- [Solução de Problemas](#solução-de-problemas)

## 🎯 Sobre o Projeto

Esta aplicação demonstra como criar um ambiente completo de desenvolvimento PHP com MySQL utilizando containers Docker. O projeto inclui:

- Conexão PDO com MySQL
- Gerenciamento de variáveis de ambiente
- Configuração flexível para diferentes ambientes
- Estrutura organizada e escalável

## 🚀 Tecnologias

- **PHP 8.2** com Apache
- **MySQL 8.0**
- **Docker** e **Docker Compose**
- **Composer** para gerenciamento de dependências
- **vlucas/phpdotenv** para variáveis de ambiente

## 📁 Estrutura do Projeto

```
Projeto/
├── public/              # Diretório público da aplicação
│   ├── index.php        # Página principal
│   └── conn.php         # Classe de conexão com o banco
├── workflow/            # Configurações do Docker
│   └── docker-compose.yaml
├── vendor/              # Dependências do Composer
├── composer.json        # Arquivo de dependências PHP
├── Dockerfile           # Configuração da imagem Docker
├── .env                 # Variáveis de ambiente (não versionado)
├── .env.example         # Exemplo de variáveis de ambiente
└── .replit              # Configuração para Replit
```

## ✅ Pré-requisitos

- Docker e Docker Compose instalados
- PHP 8.2+ e Composer (para desenvolvimento local sem Docker)
- Git
- MySQL Server (para testes locais, podendo usar XAMPP, WAMP ou Laragon)

## 🔧 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/clcmo/dockercomsitePHP.git
cd dockercomsitePHP
```

### 2. Configure as variáveis de ambiente

```bash
cp .env.example .env
```

Edite o arquivo `.env` conforme necessário:

```env
DB_HOST=mysql
DB_PORT=3306
DB_NAME=meu_banco
DB_USER=root
DB_PASSWORD=senha_segura
```

### 3. Instale as dependências

```bash
composer install
```

## 💻 Uso

### Ambiente Docker (Recomendado)

```bash
# Inicie os containers
cd workflow
docker-compose up -d

# Acesse a aplicação
http://localhost:8000
```

```bash
# Crie uma imagem na pasta raiz
docker build -t minhaimagemphp .

# Acesse a aplicação, usando o Docker Hub, 
# Selecione a imagem 
# Clique na opção Run e configure com a porta 8000

# Acesse a aplicação
http://localhost:8000

# Suba a imagem no DockerHub em
docker tag minhaimagemphp:latest seuuser/minhaimagemphp:v1.0   
docker push seuuser/minhaimagemphp:v1.0
```

### Ambiente Local (Desenvolvimento)

```bash
# Inicie o servidor PHP
php -S localhost:5000 -t public/

# Acesse a aplicação
http://localhost:5000
```

**Nota:** No ambiente local, você precisará de um MySQL rodando separadamente.

### Comandos Úteis

```bash
# Ver logs dos containers
docker-compose logs -f

# Parar os containers
docker-compose down

# Reconstruir os containers
docker-compose up -d --build

# Acessar o container PHP
docker-compose exec app bash

# Acessar o MySQL
docker-compose exec mysql mysql -u root -p
```

## ⚙️ Configuração

### Docker Compose

O arquivo `workflow/docker-compose.yaml` define dois serviços:

**Serviço MySQL:**
- Porta: `3308` (externa) → `3306` (interna)
- Volume persistente para dados
- Variáveis de ambiente configuráveis

**Serviço App (PHP):**
- Porta: `8000` (externa) → `80` (interna)
- Build customizado via Dockerfile
- Dependência do serviço MySQL

### Dockerfile

Baseado em PHP 8.2 com Apache, inclui:
- Extensões: PDO, PDO MySQL, MySQLi, ZIP
- Composer para gerenciamento de dependências
- Permissões corretas para Apache

### Classe Database (conn.php)

Gerencia a conexão com MySQL através de PDO:
- Carrega variáveis de ambiente via phpdotenv
- Fallbacks para valores padrão
- Tratamento de erros
- Suporte para diferentes ambientes

## 🌐 Deploy

### Replit

O projeto está configurado para funcionar no Replit:

1. Importe o repositório no Replit
2. Configure as variáveis de ambiente no Secrets
3. Execute o projeto (usa PHP Server na porta 5000)

### Produção

Para deploy em produção, os containers Docker são utilizados:

```bash
docker-compose -f workflow/docker-compose.yaml up -d
```

## 🔍 Solução de Problemas

### Autoload não encontrado

**Problema:** `require(__DIR__/vendor/autoload.php): Failed to open stream`

**Solução:** O projeto usa caminhos relativos corretos:
- Local: `require __DIR__ . '/vendor/autoload.php';`
- Replit/Externo: `require __DIR__ . '/../vendor/autoload.php';`

### Não consegue conectar ao MySQL

**Verifique:**
1. Os containers estão rodando: `docker-compose ps`
2. As variáveis de ambiente estão corretas no `.env`
3. O MySQL está acessível: `docker-compose logs mysql`
4. No Docker, use `DB_HOST=mysql` (nome do serviço)

### Porta já em uso

Se a porta 8000 ou 3308 já estiver em uso, altere no `docker-compose.yaml`:

```yaml
ports:
  - "8001:80"  # Mude 8000 para 8001
```

## 📝 Licença

Este projeto é um material educacional de código aberto.

## 👤 Autor

**clcmo**
- GitHub: [@clcmo](https://github.com/clcmo)

## 🤝 Contribuindo

Contribuições, issues e feature requests são bem-vindos!

---

⭐ Se este projeto foi útil, considere dar uma estrela no repositório!