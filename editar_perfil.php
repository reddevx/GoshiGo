<?php
include('conexão.php');

// Lógica para obter e exibir informações do usuário, por exemplo:

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: login.php");
    exit();
}

include('conexão.php');

$usuario_id = $_SESSION['usuario_id'];
$html_content = ""; // Variável para armazenar o HTML dos animais


$sql = "SELECT * FROM usuarios WHERE id = $id_usuario";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Exibir formulário preenchido com as informações atuais do usuário
    ?>
    <form action="atualizar_perfil.php" method="POST">
        <input type="text" name="nome" value="<?php echo $row['nome']; ?>">
        <input type="email" name="email" value="<?php echo $row['email']; ?>">
        <input type="submit" value="Salvar Alterações">
    </form>
    <?php
} else {
    echo "Usuário não encontrado.";
}

$mysqli->close();
?>
