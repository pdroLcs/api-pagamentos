# API de Pagamentos

Uma API RESTful moderna para gerenciamento de faturas e pagamentos, construída com Laravel 12 e suportando autenticação via tokens.

## 📋 Características

- ✅ Autenticação segura com Sanctum (tokens de acesso pessoal)
- ✅ Gerenciamento de usuários
- ✅ Gerenciamento de faturas (invoices)
- ✅ Filtros avançados para faturas
- ✅ Controle de permissões baseado em abilities
- ✅ API versionada (V1)
- ✅ Localização em português (pt_BR)

## 🚀 Requisitos

- **PHP**: ^8.2
- **Composer**: Gerenciador de dependências do PHP
- **SQLite ou MySQL**: Banco de dados (configurado em `.env`)
- **XAMPP** (opcional): Stack PHP/MySQL local

## 📦 Dependências Principais

### Backend
- **laravel/framework** (^12.0) - Framework principal
- **laravel/sanctum** (^4.0) - Autenticação com tokens
- **laravel/tinker** (^2.10.1) - REPL interativo

### Desenvolvimento
- **fakerphp/faker** (^1.23) - Gerador de dados falsos

## 🔧 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/pdroLcs/api-pagamentos
cd api-pagamentos
```

### 2. Setup 

```bash
# Instalar dependências PHP
composer install

# Copiar arquivo de configuração
copy .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Executar migrations
php artisan migrate
```

### 3. Gerar dados de teste (opcional)

```bash
php artisan migrate:refresh --seed
```

## ▶️ Iniciar a Aplicação

### Apenas o servidor PHP

```bash
php artisan serve
```

A API estará disponível em `http://localhost:8000`

## 📚 API Endpoints

### Base URL
```
http://localhost:8000/api/v1
```

### Autenticação

#### Login
```http
POST /login
Content-Type: application/json

{
  "email": "usuario@example.com",
  "password": "senha"
}
```

**Resposta:**
```json
{
  "access_token": "token_aqui",
  "token_type": "Bearer"
}
```

#### Logout
```http
POST /logout
Authorization: Bearer {access_token}
```

### Usuários

#### Listar usuários
```http
GET /users
```

#### Obter usuário específico
```http
GET /users/{id}
Authorization: Bearer {access_token}
Abilities: user-get
```

### Faturas

#### Listar faturas
```http
GET /invoices
```

**Filtros disponíveis:**
- `user_id`: Filtrar por usuário
- `status`: Filtrar por status (paid, unpaid)
- `type`: Filtrar por tipo
- `value`: Filtrar por valor

Exemplo:
```http
GET /invoices?user_id=1&status=paid
```

#### Criar fatura
```http
POST /invoices
Authorization: Bearer {access_token}
Abilities: invoice-store, user-update
Content-Type: application/json

{
  "user_id": 1,
  "type": "invoice",
  "value": 100.50,
  "paid": false,
  "payment_date": "2025-12-15"
}
```

#### Atualizar fatura
```http
PUT /invoices/{id}
Authorization: Bearer {access_token}
Abilities: invoice-store, user-update
Content-Type: application/json

{
  "paid": true,
  "payment_date": "2025-12-09"
}
```

#### Deletar fatura
```http
DELETE /invoices/{id}
Authorization: Bearer {access_token}
Abilities: invoice-store, user-update
```

## 🗂️ Estrutura do Projeto

```
api-pagamentos/
├── app/
│   ├── Filters/              # Filtros customizados
│   │   ├── Filter.php
│   │   └── InvoiceFilter.php
│   ├── Http/
│   │   ├── Controllers/      # Controllers da API
│   │   └── Resources/        # Transformadores de resposta
│   ├── Models/               # Modelos Eloquent
│   │   ├── Invoice.php
│   │   └── User.php
│   ├── Providers/            # Service providers
│   └── Traits/               # Traits compartilhadas
├── config/                   # Configurações da aplicação
├── database/
│   ├── migrations/           # Migrações do banco
│   ├── factories/            # Factories para testes
│   └── seeders/              # Seeders para popular BD
├── routes/
│   ├── api.php               # Rotas da API
│   ├── web.php               # Rotas web
│   └── console.php           # Comandos console
├── storage/                  # Arquivos gerados pela app
└── bootstrap/                # Arquivos de bootstrap
```

## 🔐 Autenticação e Permissões

O projeto usa **Laravel Sanctum** para autenticação via tokens e controla permissões através de **abilities**:

### Abilities Disponíveis

- `user-get` - Ver detalhes do usuário
- `invoice-store` - Criar/atualizar faturas
- `user-update` - Atualizar dados de usuário
- `teste-index` - Acessar rota de teste

### Tokens de Teste

Tokens pré-configurados (veja em `routes/api.php`):

```
Invoice:  7|LhYYDGheYQdJ1ZZMB2OGic0GQOJyESL1xO3AyUIk7aa70588
User:     6|jTwRWyCc0PJv38CEVtyiVSrDIb4iJuMDmIaY4sv8fb5a45f3
Teste:    8|F4tozlwFIQEN8xtMMj6mK50mNgJaEub4vD4WW3Rnaab974c9
```

## 📝 Configuração (.env)

Exemplo de arquivo `.env`:

```env
APP_NAME="API Pagamentos"
APP_ENV=local
APP_KEY=base64:xxxxx
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# ou
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=api_pagamentos
# DB_USERNAME=root
# DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log
```

## 🌍 Localização

O projeto suporta português brasileiro (pt_BR):
- Validação: `lang/pt_BR/validation.php`
- Autenticação: `lang/pt_BR/auth.php`
- Paginação: `lang/pt_BR/pagination.php`
- Senhas: `lang/pt_BR/passwords.php`

## 🛠️ Comandos Úteis

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear

# Resetar banco de dados
php artisan migrate:refresh

# Resetar banco com seeds
php artisan migrate:refresh --seed

# Gerar novo token pessoal
php artisan tinker
# Dentro do tinker:
# >>> $user = User::first();
# >>> $user->createToken('token-name');

# Code formatting
./vendor/bin/pint

# Listar rotas
php artisan route:list

# Executar seeder específico
php artisan db:seed --class=DatabaseSeeder
```
