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
        $verifica = $filtro['usuario'];

        $sql = "SELECT * FROM t_usuario WHERE usuario = :USUARIO ";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':USUARIO', $verifica);
        $stmt->execute();

        if($stmt->rowCount() > 0){
                echo 'Este login já está em uso!';
        }else{
                echo 'Não existe!';
        }