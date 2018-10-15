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
$idSenha = isset($filtro['idSenha']) ? $filtro['idSenha'] : null;

$sql = 'UPDATE t_senhas SET alerta = 0 WHERE id = :ID';
$stmt->bindParam(':ID', $idSenha);
$stmt = $conexao->prepare($sql);
$stmt->execute();
