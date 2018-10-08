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

$sql = 'SELECT ser.nomeServico, s.id, s.sigla, s.numero, s.identificacao, p.preferencia FROM t_servicos ser, t_senhas s, t_preferencia p
                WHERE ser.id = s.t_servicos_id AND p.id = s.t_preferencia_id
                AND s.situacao = "Aguardando" AND s.t_preferencia_id = 1 AND
                s.t_filas_id = :IDFILA AND s.t_usuario_id IS NULL;';

$stmt = $conexao->prepare($sql);
$stmt->bindParam(':IDFILA', $idFila);
$stmt->execute();
$senhasNormais = $stmt->fetchAll(PDO::FETCH_OBJ);

$sql2 = 'SELECT ser.nomeServico, s.id, s.sigla, s.numero, s.identificacao, p.preferencia FROM t_servicos ser, t_senhas s, t_preferencia p
                WHERE ser.id = s.t_servicos_id AND p.id = s.t_preferencia_id
                AND s.situacao = "Aguardando" AND s.t_preferencia_id = 2 AND
                s.t_filas_id = :IDFILA AND s.t_usuario_id IS NULL;';

$stmt2 = $conexao->prepare($sql2);
$stmt2->bindParam(':IDFILA', $idFila);
$stmt2->execute();
$senhasPreferenciais = $stmt2->fetchAll(PDO::FETCH_OBJ);
$npessoas = count($senhasPreferenciais) + count($senhasNormais);
if (count($senhasNormais) === 0 && count($senhasPreferenciais) === 0) {
    echo "NULL";
} else {

    if (count($senhasPreferenciais) !== 0) {
        $preferencial = new ArrayObject($senhasPreferenciais[0]);
        $preferencial->offsetSet('npessoas', $npessoas);
        echo json_encode($senhasPreferenciais[0]);
    } else {
        $normal = new ArrayObject($senhasNormais[0]);
        $normal->offsetSet('npessoas', $npessoas);
        echo json_encode($normal);
    }
}
