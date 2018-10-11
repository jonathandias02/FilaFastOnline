<?php

$dsn = "mysql:host=localhost;dbname=unieuro;charset=utf8";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO($dsn, $usuario, $senha);
} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = isset($filtro['nome']) ? $filtro['nome'] : null;
$sigla = isset($filtro['sigla']) ? $filtro['sigla'] : null;

if ($nome !== null && $sigla === null) {

    $sql = "SELECT * FROM t_servicos WHERE nomeServico = :NOME and deletar = 0";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':NOME', $nome);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo 'Este nome já está em uso!';
    } else {
        echo 'Não existe!';
    }
} else if($sigla !== null && $nome === null) {
    $sql = "SELECT * FROM t_servicos WHERE sigla = :SIGLA and deletar = 0";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':SIGLA', $sigla);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo 'Esta sigla já está em uso!';
    } else {
        echo 'Não existe!';
    }
}