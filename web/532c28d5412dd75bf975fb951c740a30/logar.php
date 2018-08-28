<?php

include "conexao.php";
$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = $filtro['email'];
$senha = $filtro['senha'];

$sql_verificar = "SELECT * FROM t_usuariosapp WHERE email = :EMAIL and senha = :SENHA";
$stmt = $conexao->prepare($sql_verificar);
$stmt->bindParam(':EMAIL', $email);
$stmt->bindParam(':SENHA', $senha);
$stmt->execute();
$retorno = $stmt->fetch();

if ($stmt->rowCount() > 0) {
    $retornoApp = array('LOGIN' => 'SUCESSO', 'nome' => $retorno['nome'], 'email' => $retorno['email']);
} else {
    $retornoApp = array('LOGIN' => 'ERRO');
}

echo json_encode($retornoApp);
