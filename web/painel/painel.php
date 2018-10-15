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
$idSenha = isset($filtro['idSenha']) ? $filtro['idSenha'] : null;

if ($idSenha == null && $idFila != null) {
    $sql = 'SELECT id, sigla, numero, guiche, alerta, t_preferencia_id FROM t_senhas WHERE situacao != "Aguardando" AND t_filas_id = :IDFILA ORDER BY dataChamada DESC LIMIT 5';

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':IDFILA', $idFila);
    $stmt->execute();
    $senhas = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($senhas);
} else {
    $sql2 = 'UPDATE t_senhas SET alerta = 0 WHERE id = :ID';
    $stmt = $conexao->prepare($sql2);
    $stmt->bindParam(':ID', $idSenha);
    $stmt->execute();
}