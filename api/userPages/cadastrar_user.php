<?php
session_start();
require_once '../conexao.php'; // $conn (mysqli)

// Apenas POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: criar.php');
  exit;
}

$nome  = trim($_POST['nome']  ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

// Validação mínima
if ($nome === '' || $email === '' || $senha === '') {
  $_SESSION['flash'] = ['msg' => 'Preencha nome, e-mail e senha.', 'type' => 'err'];
  header('Location: criar.php'); exit;
}

// Verifica duplicidade de e-mail
$chk = $conn->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
$chk->bind_param("s", $email);
$chk->execute();
if ($chk->get_result()->num_rows > 0) {
  $_SESSION['flash'] = ['msg' => 'E-mail já cadastrado.', 'type' => 'err'];
  header('Location: criar.php'); exit;
}

// Insere com hash
$hash = password_hash($senha, PASSWORD_DEFAULT);
$ins = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$ins->bind_param("sss", $nome, $email, $hash);

if ($ins->execute()) {
  $_SESSION['flash'] = ['msg' => 'Cadastro realizado! Faça login.', 'type' => 'ok'];
  header('Location: ../index.php'); // tela de login
  exit;
}

$_SESSION['flash'] = ['msg' => 'Erro ao cadastrar: '.$conn->error, 'type' => 'err'];
header('Location: criar.php'); exit;