<?php
// Configurações do banco de dados no Byet.host
$host = 'sql100.byethost17.com'; // Host fornecido pelo Byet.host
$user = 'b17_40231266';          // Usuário do banco
$pass = 'gom2008dn';                       // Se você tiver definido senha no painel, coloque aqui
$db   = 'b17_40231266_sistema_arquivos'; // Nome do banco no formato Byet.host

// Conexão com o banco
$conn = mysqli_connect($host, $user, $pass, $db);

// Verifica se ocorreu algum erro
if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}

// Define charset para UTF-8
mysqli_set_charset($conn, 'utf8mb4');
?>
