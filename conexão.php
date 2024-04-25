<?php
$host = 'localhost'; // Host do banco de dados (geralmente 'localhost')
$usuario = 'root'; // Nome de usuário do MySQL
$senha = 'root'; // Senha do MySQL
$banco = 'anidex'; // Nome do banco de dados

// Estabelecer conexão com o banco de dados MySQL
$mysqli = new mysqli($host, $usuario, $senha, $banco);

// Verificar se a conexão foi bem-sucedida
if ($mysqli->connect_error) {
    die('Erro de conexão: ' . $mysqli->connect_error);
}
?>