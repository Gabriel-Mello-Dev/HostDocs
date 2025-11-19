# **HostDocs**

HostDocs é um sistema simples de **gestão de arquivos** desenvolvido em **PHP**.
Permite cadastro de usuários, login, upload de arquivos, listagem, download e exclusão.
A interface utiliza **TailwindCSS via CDN** e os metadados são armazenados em **MySQL**.

---

## ✨ **Funcionalidades Principais**

* ✔️ Cadastro e login de usuários
* ✔️ Upload com validação de extensão e limite de **5 MB**
* ✔️ Suporte a arquivos: **PNG, JPG, JPEG, PDF, DOC, DOCX**
* ✔️ Listagem dos arquivos do usuário com *preview* para imagens
* ✔️ Download e exclusão com verificação **CSRF** básica
* ✔️ Armazenamento de metadados no MySQL

---

## 📁 **Estrutura do Projeto**

```
.
├── Bd/
│   └── sistema_arquivos.sql
├── conexao/
│   ├── conexao.php
│   └── config.php
├── functions/
│   ├── upload.php
│   └── excluir.php
├── sitemPages/
│   ├── uploadArquivos.php
│   └── listar.php
├── userPages/
│   ├── cadastrar_user.php
│   ├── criar.php
│   └── logout.php
├── uploads/
├── index.php
└── verificarUser.php
```

---

## 🔧 **Requisitos**

* PHP **7.4+**
* Extensões:

  * PDO MySQL e/ou mysqli
* MySQL / MariaDB
* Servidor web (Apache, Nginx ou PHP embutido)
* Permissão de escrita na pasta **uploads/**

---

## 🚀 **Instalação**

### 1. Copie o projeto

Extraia/clique os arquivos para o diretório do seu servidor, ex:

```
/var/www/hostdocs
```

### 2. Crie o banco de dados e importe o arquivo SQL:

```sh
mysql -u SEU_USUARIO -p -e "CREATE DATABASE sistema_arquivos;"
mysql -u SEU_USUARIO -p sistema_arquivos < Bd/sistema_arquivos.sql
```

### 3. Configure a conexão com o banco

Arquivos:

* `conexao/conexao.php` (mysqli)
* `conexao/config.php` (PDO)

Exemplo (PDO):

```php
$db_host = 'localhost';
$db_user = 'seu_usuario';
$db_pass = 'sua_senha';
$db_name = 'sistema_arquivos';
```

### 4. Defina permissões na pasta uploads/

```sh
sudo chown -R www-data:www-data uploads/
sudo chmod -R 755 uploads/
```

### 5. (Opcional) Executar localmente:

```sh
php -S localhost:8000
```

---

## 🧭 **Como Usar**

1. Abra o arquivo via xampp **index.php**
2. Faça login ou cadastre-se
3. Acesse `sitemPages/uploadArquivos.php` para enviar arquivos
4. Acesse `sitemPages/listar.php` para visualizar, baixar ou excluir

---
