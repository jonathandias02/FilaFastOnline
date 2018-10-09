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
$idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;

$sql = 'SELECT id, nomeServico FROM t_servicos WHERE t_filas_id = :IDFILA';

$stmt = $conexao->prepare($sql);
$stmt->bindParam(':IDFILA', $idFila);
$stmt->execute();
$servicos = $stmt->fetchAll(PDO::FETCH_OBJ);

if (count($servicos) > 0) {
    echo json_encode($servicos);
}else{
    echo "NULL";
}

