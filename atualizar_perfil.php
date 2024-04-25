<?php
include('conexão.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = 1; // Substitua pelo ID do usuário logado
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id_usuario";

    if ($mysqli->query($sql) === TRUE) {
        echo "Perfil atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o perfil: " . $mysqli->error;
    }
}

$mysqli->close();
?>
