<?php
session_start();
require_once '../conexao/config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para fazer upload.';
    $_SESSION['tipo'] = 'erro';
    header('Location: ../sitemPages/login.php');
    exit;
}

// Verifica se o arquivo foi enviado
if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['mensagem'] = 'Erro ao enviar arquivo.';
    $_SESSION['tipo'] = 'erro';
    header('Location: ../sitemPages/listar.php');
    exit;
}

$arquivo = $_FILES['arquivo'];
$descricao = $_POST['descricao'] ?? '';

// Validações
$nomeOriginal = $arquivo['name'];
$tamanho = $arquivo['size'];
$tmpName = $arquivo['tmp_name'];
$tipo = $arquivo['type'];

// Extensões permitidas
$extensoesPermitidas = ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx'];
$extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

if (!in_array($extensao, $extensoesPermitidas)) {
    $_SESSION['mensagem'] = 'Formato de arquivo não permitido. Use: PNG, JPG, PDF, DOC ou DOCX.';
    $_SESSION['tipo'] = 'erro';
    header('Location: ../sitemPages/listar.php');
    exit;
}

// Tamanho máximo: 5MB
$tamanhoMaximo = 5 * 1024 * 1024; // 5MB
if ($tamanho > $tamanhoMaximo) {
    $_SESSION['mensagem'] = 'Arquivo muito grande. Tamanho máximo: 5MB.';
    $_SESSION['tipo'] = 'erro';
    header('Location: ../sitemPages/listar.php');
    exit;
}

// Gera nome único para evitar sobrescrever
$nomeSalvo = uniqid('file_', true) . '.' . $extensao;
$diretorioUpload = __DIR__ . '/../uploads/'; // caminho físico no servidor
$caminhoCompleto = $diretorioUpload . $nomeSalvo;

// Cria pasta uploads se não existir
if (!is_dir($diretorioUpload)) {
    mkdir($diretorioUpload, 0755, true);
}

// Move o arquivo
if (!move_uploaded_file($tmpName, $caminhoCompleto)) {
    $_SESSION['mensagem'] = 'Erro ao salvar arquivo no servidor.';
    $_SESSION['tipo'] = 'erro';
    header('Location: ../sitemPages/uploadArquivos.php');
    exit;
}

// Caminho relativo para salvar no banco (para links)
$caminhoBanco = '/uploads/' . $nomeSalvo;

// Salva no banco de dados
try {
    $sql = "INSERT INTO arquivos (nome_original, nome_salvo, tipo, tamanho, caminho, usuario_id, descricao) 
            VALUES (:nome_original, :nome_salvo, :tipo, :tamanho, :caminho, :usuario_id, :descricao)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome_original' => $nomeOriginal,
        ':nome_salvo' => $nomeSalvo,
        ':tipo' => $tipo,
        ':tamanho' => $tamanho,
        ':caminho' => $caminhoBanco,
        ':usuario_id' => $_SESSION['user_id'],
        ':descricao' => $descricao
    ]);

    $_SESSION['mensagem'] = 'Arquivo enviado com sucesso!';
    $_SESSION['tipo'] = 'sucesso';
    
} catch (PDOException $e) {
    // Remove arquivo se falhar no banco
    unlink($caminhoCompleto);
    $_SESSION['mensagem'] = 'Erro ao salvar no banco de dados: ' . $e->getMessage();
    $_SESSION['tipo'] = 'erro';
}

header('Location: ../sitemPages/listar.php');
exit;
?>
