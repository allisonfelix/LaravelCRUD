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

## 8. Criando um Usuário Administrador
Para testar o painel de administração, é necessário ter um usuário com privilégios administrativos. Como o cadastro via interface não permite criar um administrador diretamente, você precisará inserir ou atualizar um registro no banco de dados, configurando o campo `is_admin` como `true` ou, no caso do MySQL, como `1`.

### Atenção:
#### Se você tiver problemas de login utilizando o `bcrypt`, prefira gerar a senha com `Hash::make`, que é a função recomendada pelo Laravel para criptografia de senhas.

### Opção 1: Criando o Administrador Diretamente com o Tinker
Você pode criar o usuário administrador diretamente pelo Tinker:
<br>

#### 1. Abra o Tinker:
```bash
php artisan tinker
```
<br>

#### 2. Execute o seguinte código:
```php
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

Usuario::create([
    'nome' => 'Administrador',
    'data_nascimento' => '2000-01-01',
    'sexo' => 'Masculino',
    'usuario' => 'admin',
    'senha' => Hash::make('sua_senha'),
    'is_admin' => true,
]);
```
<br>
Substitua `'sua_senha'` pela senha desejada.
<br>

### Opção 2: Gerando o Hash da Senha e Atualizando Diretamente no MySQL
Se preferir, você pode gerar o hash da senha via Tinker e, em seguida, atualizar o registro diretamente no MySQL:

#### 1. Abra o Tinker:
```bash
php artisan tinker
```
<br>

#### 2. Gere o hash da senha:
```php
echo Hash::make('sua_senha');
```
Copie o valor gerado.
<br>
#### 3. Crie um usuário normal (não administrador) pela interface ou inserindo manualmente.
#### 4. Acesse seu banco de dados e atualize o registro do usuário para definir is_admin como 1 e, se necessário, substitua a senha pelo hash gerado:
```sql
UPDATE usuarios 
SET senha = '<hash_gerado>', is_admin = 1 
WHERE usuario = 'admin';
```
Com essas abordagens, você garante que a senha seja gerada de forma correta utilizando Hash::make e evita problemas de login. Lembre-se de realizar esse procedimento em cada ambiente onde o projeto for testado (local ou remoto).
<br>
***
Escolha a opção que melhor se adapta à sua rotina de desenvolvimento para garantir o funcionamento completo dos dashboards de usuário e administrador.
