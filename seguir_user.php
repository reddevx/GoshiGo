<?php
include ('conexão.php');
// Consulta para obter os usuários e exibir na página
$sql = "SELECT id, nome, email, foto_perfil FROM usuarios";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Nome: " . $row["nome"]. " - Email: " . $row["email"]. "<br>";
        // Exibindo a foto de perfil (substitua 'caminho_para_imagem' pelo caminho real da imagem)
        echo "<img src='caminho_para_imagem/".$row['foto_perfil']."' alt='Foto de Perfil' width='100' height='100'><br>";
        // Botão para seguir usuário
        echo "<button onclick='seguirUsuario(".$row['id'].")'>Seguir</button><br><br>";
    }
} else {
    echo "Nenhum usuário encontrado.";
}

// Fechar a conexão
$mysqli->close();
?>
