<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include('conexão.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $animal_id = $_GET['id'];
    
    // Ajuste o nome da coluna para o identificador único correto da tabela
    $sql_delete = "DELETE FROM bestiario_animais WHERE id = $animal_id AND usuario_id = {$_SESSION['usuario_id']}";
    
    if ($mysqli->query($sql_delete)) {
        header("Location: anidex.php"); // Redirecionar de volta para a página após a exclusão
        exit();
    } else {
        echo "Erro ao excluir o animal: " . $mysqli->error;
    }
} else {
    echo "ID do animal inválido";
}

$mysqli->close();
?>
