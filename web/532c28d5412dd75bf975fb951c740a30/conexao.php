<?php

	$dsn = "mysql:host=localhost;dbname=atendimentos_solutions;charset=utf8";
	$usuario = "root";
	$senha = "";

	try{
		$conexao = new PDO($dsn, $usuario, $senha);

	}catch(PDOException $e){
		echo "conexao_erro";
		exit;
	}