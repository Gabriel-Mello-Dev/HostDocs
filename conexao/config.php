<?php
// config.php - configuração PDO para Byet.host

// Dados do Byet.host (substitua a senha e, se necessário, o nome do DB)
$db_host = 'sql100.byethost17.com';
$db_user = 'b17_40231266';
$db_pass = 'gom2008dn'; // <-- coloque a senha que você definiu no painel
$db_name = 'b17_40231266_sistema_arquivos'; // confirme o nome exato no painel

// Opcional: porta padrão 3306 (pode remover se não precisar)
$db_port = 3306;

try {
    $dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Em ambiente de produção você não deve exibir a mensagem completa.
    // Aqui mostramos para debug temporário — depois remova ou logue em arquivo.
    die("Erro na conexão: " . $e->getMessage());
}
?>
