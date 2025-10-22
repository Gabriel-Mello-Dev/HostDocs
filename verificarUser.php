<?php
session_start();
include 'conexao.php';

// Verifica se os dados foram enviados
$email = isset($_POST['username']) ? $_POST['username'] : '';
$senha = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email) || empty($senha)) {
    header('Location: index.php?error=empty');
    exit;
}

// Prepared statement para segurança
$stmt = mysqli_prepare($conn, "SELECT * FROM usuarios WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($senha, $user['senha'])) {
        $_SESSION['log'] = true;
        $_SESSION['user'] = $email;
        $_SESSION['user_id'] = $user['id'];
        header('Location: ./sitemPages/uploadArquivos.php');
        exit;
    } else {
        header('Location: index.php?error=senha');
        exit;
    }
} else {
    header('Location: index.php?error=usuario');
    exit;
}
?>
