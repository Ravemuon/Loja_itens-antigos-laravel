# 🎵 Barganha - Loja de Itens Antigos

[![Status do Projeto](https://img.shields.io/badge/status-em%20desenvolvimento-yellow)]()
[![IFSC](https://img.shields.io/badge/IFSC-Chapec%C3%B3-blue)]()
[![Laravel](https://img.shields.io/badge/Laravel-11.x-red)]()
[![PHP](https://img.shields.io/badge/PHP-8.2+-purple)]()
[![License](https://img.shields.io/badge/license-MIT-green)]()

---

## 📋 Sobre o Projeto

A **Barganha** é um sistema de e-commerce desenvolvido em **Laravel** para uma loja especializada na venda de **itens antigos e colecionáveis**, como discos de vinil, filmes em DVD, jogos, livros raros e outros objetos de valor histórico e cultural.

O projeto foi desenvolvido como parte da disciplina de **Desenvolvimento de Aplicações Web** no **IFSC - Câmpus Chapecó**, aplicando conceitos de **Programação Orientada a Objetos**, **MVC**, **Eloquent ORM** e **relacionamentos entre tabelas**.

---

## 👤 Credenciais de Acesso

### Administrador
Acesso total ao painel administrativo para gerenciar produtos, categorias, pedidos e clientes.

| Campo | Valor |
| :--- | :--- |
| **E-mail** | `admin@barganha.com` |
| **Senha** | `admin123` |

### Cliente (Usuário Comum)
Acesso ao catálogo de produtos, carrinho de compras e histórico de pedidos.  
*(Para testes, crie um novo usuário ou utilize as credenciais geradas pelos seeders.)*

---

## 🚀 Funcionalidades Principais

### 🛍️ Catálogo de Produtos
- Listagem de itens antigos com imagens, descrições, ano e preço.
- Filtros por categoria (Vinil, DVD, Jogos, Livros, etc.).
- Busca por nome ou descrição.
- Página de detalhes do produto com informações completas.

### 🛒 Carrinho de Compras
- Adição e remoção de produtos.
- Atualização de quantidades.
- Cálculo de subtotal e total.

### 📦 Pedidos e Checkout
- Finalização de compra com dados de entrega.
- Status do pedido (Pendente, Pago, Enviado, Entregue).
- Histórico de pedidos do cliente.

### 👥 Autenticação e Usuários
- Registro e login de clientes.
- Perfil de **Administrador** com permissões especiais.
- Controle de acesso baseado em middleware.

### 📊 Dashboards e Relatórios
- Gráficos de produtos mais vendidos (Chart.js).
- Relatório de vendas por período.
- Relatório de pedidos em PDF (DomPDF).

---

## 🛠️ Tecnologias Utilizadas

- **PHP 8.2+** / **Laravel 11.x**
- **Eloquent ORM** (relacionamentos 1:1, 1:N, N:N)
- **MySQL** (banco de dados relacional)
- **Blade** (template engine)
- **Bootstrap 5** (front-end responsivo)
- **Chart.js** (gráficos)
- **DomPDF** (relatórios)
- **Composer** / **NPM** / **Git**

---

## 📥 Como Executar o Projeto Localmente

### Pré-requisitos

| Ferramenta | Download |
| :--- | :--- |
| **Laravel Herd** | [herd.laravel.com](https://herd.laravel.com/windows) |
| **Laragon** | [laragon.org](https://laragon.org/download) |
| **Visual Studio Code** | [code.visualstudio.com](https://code.visualstudio.com/) |

### Passo a Passo

```bash
# 1. Clone o repositório
git clone https://github.com/Ravemuon/barganha-laravel.git
cd barganha-laravel

# 2. Instale as dependências PHP
composer install

# 3. Instale as dependências front-end (opcional)
npm install
npm run build

# 4. Configure o ambiente
cp .env.example .env
# Edite o .env com as credenciais do seu banco de dados

# 5. Gere a chave da aplicação
php artisan key:generate

# 6. Execute as migrations e seeders (dados iniciais)
php artisan migrate --seed

# 7. Crie o link simbólico para imagens
php artisan storage:link

# 8. Inicie o servidor
php artisan serve
