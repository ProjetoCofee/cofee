<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

	$id  = $_POST["id"];
	$id_entrada = $_POST["id_entrada"];

	$sql = "DELETE FROM entrada_produto WHERE id = '".$id."'";

	$result = $mysqli->query($sql);

	$sql = mysqli_query($mysqli, "SELECT
		entrada_produto.id,
	    entrada_produto.id_entrada,
		produtos.descricao as descricao_produto,
		entrada_produto.quantidade	
		FROM produtos, entrada_produto, entrada
		WHERE produtos.id = entrada_produto.id_produto 
		AND entrada.id = entrada_produto.id_entrada 
		AND entrada_produto.id_entrada = '".$id_entrada."'");


	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado); 
	}  

	echo json_encode($data);
 
?>