<?php
session_start();
include 'conexao.php';

$email = $_POST['username'];
$senha = $_POST['password'];

// Busca apenas por email
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
   
    // Verifica a senha com hash
    if (password_verify($senha, $user['senha'])) {
        echo "deu certo";
        $_SESSION['log'] = true;
        $_SESSION['user'] = $email;
        $_SESSION['user_id'] = $user['id'];
        header('Location: ./sitemPages/uploadArquivos.php');
        exit;
    } else {
        echo "deu errado: senha incorreta";
        header('Location: index.php');
        exit;
    }
} else {
    echo "deu errado: usuário não encontrado";
    header('Location: index.php');
    exit;
}
?>