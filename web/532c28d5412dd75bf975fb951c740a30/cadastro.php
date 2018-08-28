<?php

include "conexao.php";
$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = $filtro['nome'];
$email = $filtro['email'];
$senha = $filtro['senha'];

$sql_verificar = "SELECT * FROM t_usuariosapp WHERE email = :EMAIL";
$stmt = $conexao->prepare($sql_verificar);
$stmt->bindParam(':EMAIL', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $retornoApp = array('CADASTRO' => 'EMAIL_ERRO');
} else {
    $sql_insert = "INSERT INTO t_usuariosapp(nome, email, senha) VALUES (:NOME, :EMAIL, :SENHA)";
    $stmt = $conexao->prepare($sql_insert);
    $stmt->bindParam(":NOME", $nome);
    $stmt->bindParam(":EMAIL", $email);
    $stmt->bindParam(":SENHA", $senha);
    if ($stmt->execute()) {
        $retornoApp = array('CADASTRO' => 'SUCESSO');
    } else {
        $retornoApp = array('CADASTRO' => 'ERRO');
    }
}

echo json_encode($retornoApp);
