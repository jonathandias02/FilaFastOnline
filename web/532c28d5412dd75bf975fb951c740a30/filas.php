<?php

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$banco = $filtro['nomebd'];
$dsn = "mysql:host=localhost;dbname=$banco;charset=utf8";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO($dsn, $usuario, $senha);
    
    $sql_buscar = "SELECT id, nome, nsenha, status_2 FROM t_filas";
    $query = $conexao->query($sql_buscar);
    $resultado = array();
    
    while ($filas = $query->fetch(PDO::FETCH_OBJ)){
        
        if($filas->status_2 === "ativo"){
        $resultado[] = array("ID" => $filas->id, "NOME" => $filas->nome, "NSENHA" => $filas->nsenha,
            "STATUS" => $filas->status_2);
        }
        
    }
    
    echo json_encode($resultado);
    
} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}

