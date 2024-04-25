<?php
include('system/conexão.php');
$html_content = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['termo_pesquisa'])) {
    $termo = $_GET['termo_pesquisa'];
    $sql = "SELECT * FROM usuarios WHERE nome LIKE '%$termo%' ";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Exibir os resultados da pesquisa, por exemplo:
            echo "Nome: " . $row['nome'] .   "<br>";
            echo "Nome: " . $row ['nome'] . "<br>";
        }
    } else {
        echo "Nenhum resultado encontrado.";
    }
}

$mysqli->close();
?>
