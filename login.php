<?php
session_start();

include ('conexão.php');


// Processar dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Consulta SQL para selecionar o usuário pelo e-mail
    $sql = "SELECT id, nome, senha FROM usuarios WHERE email='$email'";
    $result = $mysqli->query($sql);

    if ($result->num_rows == 1) {
        // Usuário encontrado, verificar a senha
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['usuario_id'] = $row['id']; // Armazenar ID do usuário na sessão
            echo "Login bem-sucedido! Redirecionando...";
            header("Location: home.html"); // Redirecionar para a página do painel após o login
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}

$mysqli->close();
?>
