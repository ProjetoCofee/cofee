<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;

	if($post['tipo'] == '0'){
		
		$sql = "UPDATE parcelas 
			SET valor_parcela = '".$post['valor_parcela']."', 
				data_vencimento = '".$post['data_vencimento']."'
			WHERE id = '".$post['id_parcela']."'
		";

		$result = $mysqli->query($sql);

		$count = "pendente";

	}else if($post['tipo'] == '1'){

		$sql = "UPDATE parcelas 
			SET valor_parcela = '".$post['valor_parcela']."', 
				data_vencimento = '".$post['data_vencimento']."',
				data_pagamento = '".$post['data_pagamento']."',
				id_forma_pagamento = '".$post['forma_pagamento']."'
			WHERE id = '".$post['id_parcela']."'
		";

		$result = $mysqli->query($sql);

		$count = "pago";
	}

	echo json_encode($count);    

?>