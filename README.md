# Portal Vue & Laravel

Este projeto foi desenvolvido com Vue.js (/frontend) e Laravel (/api).

## Pré-requisitos

Certifique-se de ter os seguintes pré-requisitos instalados em sua máquina:

- [PHP](https://www.php.net/manual/pt_BR/install.php) (versão 8.0 ou superior)
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://dev.mysql.com/downloads/mysql/)
- [Node.js](https://nodejs.org/) 

## Configuração do Projeto

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/thalissonst/portal.git

2. **Navegue até o diretório da api:**

   ```bash
   cd api

3. **Instale as dependências do PHP usando o Composer:**

   ```bash
   composer install

4. **Configure o banco de dados:**

   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=portal
    DB_USERNAME=root
    DB_PASSWORD=

5. **Execute as migrações:**

   ```bash
   php artisan migrate

6. **Para iniciar o servidor de desenvolvimento Laravel, use o comando:**

   ```bash
   php artisan serve

7. **Vá para o diretório do frontend e instale as dependências:**

   ```bash
   npm install

8. **Compile os arquivos:**

   ```bash
   npm run dev


   
