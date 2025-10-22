<?php
$host = 'localhost';
$user = 'root';           // ajuste seu usuário
$pass = '';               // ajuste sua senha
$db   = 'sistema_arquivos';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');
?>