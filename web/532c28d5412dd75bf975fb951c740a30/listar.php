<?php

include 'conexao.php';

$sql_buscar = "SELECT empresa, nomebd, endereco FROM t_clientes";
$query = $conexao->query($sql_buscar);

$resultado = array();

while ($empresa = $query->fetch(PDO::FETCH_OBJ)){
    
    $resultado[] = array("EMPRESA" => $empresa->empresa, "BANCODEDADOS" => $empresa->nomebd, 
        "ENDERECO" => $empresa->endereco);
    
}

echo json_encode($resultado);