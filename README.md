# Sistema de Gerenciamento de Cadastro
Este é um projeto de CRUD (create, read, update, delete) simples desenvolvido com o framework Laravel, jQuery e HTML5.<br>Mini aplicação para o cadastro de usuários, álbuns e faixas (músicas).<br>

## Requisitos

- PHP 8.4.4 ou superior
- Composer 2.8.5
- Laravel 11.41.1

## Clonando o Repositório

1. Clone este repositório na sua máquina:

   ```bash
   git clone https://github.com/allisonfelix/LaravelCRUD.git
   cd LaravelCRUD
   ```
## Configuração
2. Instale as dependências do PHP:

Se você ainda não tem o Composer instalado, você pode baixá-lo <a href="https://getcomposer.org/download/" target="_blank">aqui</a>.

Execute o comando abaixo para instalar as dependências do Laravel:
```bash
composer install
```
3. Crie o arquivo `.env`

Copie o arquivo `.env.example` para um novo arquivo `.env`:

```bash
cp .env.example .env
```

4. Gere a chave de aplicativo do Laravel<br>
O Laravel requer uma chave de aplicativo única, que pode ser gerada com o comando:

```bash
php artisan key:generate
```
<br>

## 5. Configuração do banco de dados<br>
No arquivo `.env`, configure as variáveis do banco de dados (por exemplo, `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
<br><br>
## 6. Rodar as migrações<br>
Execute as migrações para configurar o banco de dados:<br>
```bash
php artisan migrate
```

## 7. Acesse o projeto
Após configurar, você pode iniciar o servidor de desenvolvimento do Laravel:

```bash
php artisan serve
```
<br>

O servidor estará disponível em `http://localhost:8000`.<br>
