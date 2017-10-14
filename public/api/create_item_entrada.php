<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;

	$sql = "INSERT INTO entrada_produto (id_entrada,id_produto,quantidade) 

	VALUES ('".$post['id_entrada']."','".$post['id_produto']."','".$post['quantidade_produto']."')";


	$result = $mysqli->query($sql);


	$sql = mysqli_query($mysqli, "SELECT
		entrada_produto.id,
	    entrada_produto.id_entrada,
		produtos.descricao as descricao_produto,
		entrada_produto.quantidade	
		FROM produtos, entrada_produto, entrada
		WHERE produtos.id = entrada_produto.id_produto 
		AND entrada.id = entrada_produto.id_entrada 
		AND entrada_produto.id_entrada = '".$post['id_entrada']."'"); 


	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado); 
	}  


	echo json_encode($data);

?>