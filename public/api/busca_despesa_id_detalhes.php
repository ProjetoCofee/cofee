<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "
			SELECT
                contas_pagar.id,
                contas_pagar.id_categoria,
                contas_pagar.id_fornecedor as fornecedor,
                contas_pagar.descricao,
                contas_pagar.valor,
                contas_pagar.valor_pago,
                contas_pagar.qtd_parcelas,
                contas_pagar.qtd_parcelas_pagas,
                parcelas.id,
                parcelas.id_conta_receber,
                parcelas.id_forma_pagamento,
                parcelas.valor_pago,
                parcelas.valor_parcela,
                parcelas.num_parcela,
                parcelas.data_vencimento,
                parcelas.data_pagamento,
                parcelas.status,
                categoria.nome as categoria
            FROM contas_pagar, parcelas, categoria
            WHERE contas_pagar.id_categoria = categoria.id
            AND parcelas.id_conta_pagar = contas_pagar.id
			AND parcelas.id = ".$busca
		); 

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>