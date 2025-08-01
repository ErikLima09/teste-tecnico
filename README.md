# 📦 Sistema de Produtos e Usuários

Este projeto é um sistema completo desenvolvido com:

- ⚙️ Backend: **Laravel 12.21**
- 💻 Frontend: **Vue 3 + Vuetify 3**
- 🐘 Banco de dados: **PostgreSQL**
- 🔐 Autenticação via **Sanctum**
- 🧩 Funcionalidades: CRUD de produtos e usuários, login, filtros, edição, exclusão e validações no frontend.

---

## ✅ Requisitos

Antes de começar, certifique-se de ter instalado:

- [PHP 8.1+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js 18+](https://nodejs.org/)
- [NPM](https://www.npmjs.com/)
- [PostgreSQL](https://www.postgresql.org/)
- [Laravel CLI (opcional)](https://laravel.com/docs/10.x/installation)
- [Docker](https://www.docker.com/) *(opcional)*

---

## 🚀 Instalação e Execução

### 🔹 1. Clone o repositório:

```bash
git clone https://github.com/ErikLima09/teste-tecnico.git
cd teste-tecnico
```

---

## ⚙️ Backend (Laravel)

### Acesse a pasta `backend`:

```bash
cd backend
```

### Instale as dependências:

```bash
composer install
```

### Copie e configure o `.env`:

```bash
cp .env.example .env
```

Edite o `.env` com as configurações do seu PostgreSQL:

```
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

### Gere a chave da aplicação:

```bash
php artisan key:generate
```

### Rode as migrations e seeders:

```bash
php artisan migrate:fresh --seed
```

### Inicie o servidor:

```bash
php artisan serve
```

> A API estará disponível em: [http://localhost:8000](http://localhost:8000)

---

## 💻 Frontend (Vue + Vuetify)

### Acesse a pasta `frontend`:

```bash
cd ../frontend
```

### Instale as dependências:

```bash
npm install
```

### Rode a aplicação:

```bash
npm run dev
```

> A aplicação estará disponível em: [http://localhost:5173](http://localhost:5173)

---

## 🔐 Login de Teste

Use os dados criados pelo seeder para testar a aplicação:

```
E-mail: teste1@email.com
Senha: 12345678
```

---

## 📊 Relatórios SQL

Consultas SQL adicionais podem ser encontradas em:

```
backend/database/consultas.sql
```

Incluem:

- ✅ Usuários com mais produtos
- ✅ Produto mais caro por usuário

---

## 🧪 Funcionalidades testáveis

- [x] Criar e editar produtos
- [x] Filtrar produtos por nome e proprietário
- [x] Criar, editar e excluir usuários
- [x] Proteção de rotas com login e logout
- [x] Validações nos formulários (front-end)

---

## 👨‍💻 Autor

Desenvolvido por **Erik Lima** – [@ErikLima09](https://github.com/ErikLima09)

---

## 📄 Licença

Este projeto é de uso técnico e livre para fins de aprendizado.
