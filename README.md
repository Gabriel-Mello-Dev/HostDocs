HostDocs
HostDocs é um sistema simples de gestão de arquivos em PHP. Permite cadastro de
usuários, login, upload de arquivos (PNG/JPG/PDF/DOC/DOCX), listagem, download e
exclusão. A interface usa Tailwind via CDN e os metadados dos arquivos são salvos em
MySQL.
Funcionalidades Principais
Cadastro e login de usuários
Upload com validação de extensão e limite de tamanho (5 MB)
Listagem dos arquivos do usuário com preview para imagens
Download e exclusão de arquivos (com verificação CSRF básica)
Armazenamento de metadados em banco MySQL
Estrutura do Projeto
.
├── Bd/
│ └── sistema_arquivos.sql
├── conexao/
│ ├── conexao.php
│ └── config.php
├── functions/
│ ├── upload.php
│ └── excluir.php
├── sitemPages/
│ ├── uploadArquivos.php
│ └── listar.php
├── userPages/
│ ├── cadastrar_user.php
│ ├── criar.php
│ └── logout.php
├── uploads/
├── index.php
└── verificarUser.php
Requisitos
PHP 7.4+
•
•
•
•
•
•
Extensões: PDO MySQL e/ou mysqli
MySQL / MariaDB
Servidor web (Apache, Nginx) ou PHP built-in
Permissão de escrita na pasta uploads/
Instalação
Copie/extrai o projeto para o diretório do seu servidor web (ex: /var/www/hostdocs )
Crie o banco e importe o dump:
mysql -u SEU_USUARIO -p -e "CREATE DATABASE sistema_arquivos;"
mysql -u SEU_USUARIO -p sistema_arquivos < Bd/sistema_arquivos.sql
Configure as credenciais de conexão com o banco nos arquivos:
conexao/conexao.php (mysqli)
conexao/config.php (PDO)
// Exemplo (conexao/config.php)
$db_host = 'localhost';
$db_user = 'seu_usuario';
$db_pass = 'sua_senha';
$db_name = 'sistema_arquivos';
Garanta permissão de escrita na pasta uploads/ :
sudo chown -R www-data:www-data uploads/
sudo chmod -R 755 uploads/
(Opcional) Para rodar localmente:
php -S localhost:8000
Como Usar
Abra a página inicial ( index.php )
Faça login ou crie uma conta em "Cadastrar"
Vá até sitemPages/uploadArquivos.php para enviar arquivos
Veja seus arquivos em sitemPages/listar.php , podendo abrir, baixar ou excluir
