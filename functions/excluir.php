<?php
session_start();
require_once '../conexao/config.php';

function flash($msg, $type = 'ok') {
  $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  flash('Método inválido.', 'err');
  header('Location: ../sitemPages/listar.php');
  exit;
}

$csrf = $_POST['csrf'] ?? '';
if (!hash_equals($_SESSION['csrf_token'] ?? '', $csrf)) {
  flash('Falha de segurança (CSRF).', 'err');
  header('Location: ../sitemPages/listar.php');
  exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  flash('ID inválido.', 'err');
  header('Location: ../sitemPages/listar.php');
  exit;
}

// Busca o arquivo
$stmt = $pdo->prepare("SELECT id, nome_salvo, caminho FROM arquivos WHERE id = :id");
$stmt->execute([':id' => $id]);
$arquivo = $stmt->fetch();

if (!$arquivo) {
  flash('Arquivo não encontrado.', 'err');
  header('Location: ../.php');
  exit;
}

// Apaga o arquivo físico, se existir
$caminho = $arquivo['caminho'];
$caminhoFisico = __DIR__ . '/' . ltrim($caminho, '/');

if (is_file($caminhoFisico)) {
  @unlink($caminhoFisico);
}

// Remove do banco
$del = $pdo->prepare("DELETE FROM arquivos WHERE id = :id");
$del->execute([':id' => $id]);

flash('Arquivo excluído com sucesso!', 'ok');
header('Location: ../sitemPages/listar.php');
exit;