<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "recanto_olivo";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Força UTF-8
$conexao->set_charset("utf8mb4");
?>
