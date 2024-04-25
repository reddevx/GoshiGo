<?php
session_start();

include ('conexão.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: login.php");
    exit();
}

// Processar dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id'];
    $nome_animal = $_POST['nome_animal'];
    $especie = $_POST['especie'];
    $descricao = $_POST['descricao'];
    $localizacao = $_POST['localizacao'];

    // Upload da foto do animal
    $foto_nome = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_caminho = "img/" . $foto_nome; // Substitua pelo caminho correto no seu servidor

    move_uploaded_file($foto_tmp, $foto_caminho);

    // Consulta SQL para inserir o animal na tabela
    $sql = "INSERT INTO bestiario_animais (usuario_id, nome_animal, especie, foto, descricao, localizacao)
            VALUES ('$usuario_id', '$nome_animal', '$especie', '$foto_caminho', '$descricao', '$localizacao')";

    if ($mysqli->query($sql) === TRUE) {
        echo "<center>Animal Catalogado com sucesso!</center><br>";
    } else {
        echo "Erro ao cadastrar o animal: " . $mysqli->error;
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Animal Catalogado!
    </title>
    <meta name="description" content="Descrição da página">
    <meta name="author" content="Seu Nome">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap');

        body {
            font-family: 'Hammersmith One', sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
            color: #fff;
        }


        </style>
</head>
<body class="bg-dark">
    <center>
  <a href="home.html" class="btn btn-outline-primary">Voltar</a>
    </center>
</body>
</html>
