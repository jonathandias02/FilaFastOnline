<?php
        $dsn = "mysql:host=localhost;dbname=unieuro;charset=utf8";
        $usuario = "root";
        $senha = "";

        try{
                $conexao = new PDO($dsn, $usuario, $senha);

        }catch(PDOException $e){
                echo "conexao_erro";
                exit;
        }
        
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $verifica = $filtro['nome'];

        $sql = "SELECT * FROM t_filas WHERE nome = :NOME and deletar = 0";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':NOME', $verifica);
        $stmt->execute();

        if($stmt->rowCount() > 0){
                echo 'Este nome já está em uso!';
        }else{
                echo 'Não existe!';
        }