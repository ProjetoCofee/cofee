<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Marca;
use App\Produto;
use App\Entrada;
use App\Retirada;
use App\Despesa;
use App\Parcela;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Contas_Controller extends Controller
{
    public function index($atributo){
        
        if($atributo == "resumo"){

            return view('contas.contas_resumo');

        }elseif($atributo == "despesas"){

            $despesas = DB::select("
                SELECT
                contas_pagar.*,
                categoria.nome as categoria
                FROM contas_pagar, categoria
                WHERE contas_pagar.id_categoria = categoria.id
                ORDER BY contas_pagar.id DESC
            ");

            foreach ($despesas as $despesa) {

                $fornecedores = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, fornecedors
                    WHERE fornecedors.id = '".$despesa->id_fornecedor."' 
                    AND pessoa_fisicas.id = fornecedors.id_pessoa_fisica
                ");

                if($fornecedores){
                    foreach ($fornecedores as $fornecedor) {
                        $despesa->fornecedor = $fornecedor->nome;
                    }
                }else{
                    $fornecedores = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, fornecedors
                        WHERE fornecedors.id = '".$despesa->id_fornecedor."' 
                        AND pessoa_juridicas.id = fornecedors.id_pessoa_juridica
                    ");

                    foreach ($fornecedores as $fornecedor) {
                        $despesa->fornecedor = $fornecedor->nome_fantasia;
                    }
                }
            }    

            return view('contas.contas_depesas',compact('despesas'));

        }elseif($atributo == "despesas_parcelas"){

            $despesas = DB::select("
                SELECT
                    contas_pagar.id as id_conta_pagar,
                    contas_pagar.id_categoria,
                    contas_pagar.id_fornecedor as fornecedor,
                    contas_pagar.descricao,
                    contas_pagar.valor,
                    contas_pagar.valor_pago,
                    contas_pagar.qtd_parcelas,
                    contas_pagar.qtd_parcelas_pagas,
                    parcelas.id as id_parcela,
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
                ORDER BY data_vencimento ASC
            ");

            foreach ($despesas as $despesa) {

                $despesa->data_vencimento = date('d/m/Y', strtotime($despesa->data_vencimento));
                $despesa->data_pagamento = date('d/m/Y', strtotime($despesa->data_pagamento));

                $fornecedores = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, fornecedors
                    WHERE fornecedors.id = '".$despesa->fornecedor."' 
                    AND pessoa_fisicas.id = fornecedors.id_pessoa_fisica
                ");

                if($fornecedores){
                    foreach ($fornecedores as $fornecedor) {
                        $despesa->fornecedor = $fornecedor->nome;
                    }
                }else{
                    $fornecedores = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, fornecedors
                        WHERE fornecedors.id = '".$despesa->fornecedor."' 
                        AND pessoa_juridicas.id = fornecedors.id_pessoa_juridica
                    ");

                    foreach ($fornecedores as $fornecedor) {
                        $despesa->fornecedor = $fornecedor->nome_fantasia;
                    }
                }
            }

            $formas_pagamento = DB::select("
                SELECT * FROM forma_pagamento");     

            return view('contas.contas_despesas_parcelas',compact('despesas','formas_pagamento'));

        }elseif($atributo == "recebimentos"){
            
            return view('contas.contas_recebimentos');
        }
    }

    public function nova_despesa () {

        $fornecedors = DB::select("
            SELECT fornecedors.id, pessoa_fisicas.nome FROM fornecedors
            INNER JOIN pessoa_fisicas ON pessoa_fisicas.id = fornecedors.id_pessoa_fisica
            union
            SELECT fornecedors.id, pessoa_juridicas.nome_fantasia FROM fornecedors
            INNER JOIN pessoa_juridicas ON pessoa_juridicas.id = fornecedors.id_pessoa_juridica
        ");

        $categorias = DB::select("
            SELECT *
            FROM categoria
        ");

        return view('contas.contas_despesa_novo', compact('fornecedors','categorias'));
    }

    public function create_despesa (Request $despesa) {
        
        if($despesa->repete == '1'){

            $descricao = strtoupper($despesa->descricao);
            $qtd_parcelas = $despesa->qtd_parcelas;
            $data_vencimento = $despesa->data_vencimento;
            $intervalo = $despesa->intervalo;
            $meses = $despesa->intervalo/30;
            $dias = $despesa->intervalo;
            $valor_parcela = $despesa->valor/$qtd_parcelas;

            $conta_pagar = Despesa::create([
                'id_categoria'=> $despesa['categoria'],
                'id_fornecedor'=> $despesa['fornecedor'],
                'descricao'=> $despesa['descricao'],
                'valor'=> $despesa['valor'],
                'valor_pago'=> 0,
                'qtd_parcelas'=> $qtd_parcelas,
                'qtd_parcelas_pagas'=> 0,
                'status'=> 0
            ]);

            Parcela::create([
                'id_conta_pagar'=> $conta_pagar->id,
                'valor_parcela'=> $valor_parcela,
                'num_parcela' => 1,
                'data_vencimento'=> $data_vencimento,
                'status'=> 0
            ]);

            for($i=2; $i<=$qtd_parcelas; $i++){

                if($despesa->intervalo>15){

                    $data_vencimento = date('Y-m-d', strtotime($data_vencimento. ' +'.$meses.' month'));
                    Parcela::create([
                        'id_conta_pagar'=> $conta_pagar->id,
                        'valor_parcela'=> $valor_parcela,
                        'num_parcela' => $i,
                        'data_vencimento'=> $data_vencimento,
                        'status'=> 0
                    ]);

                }else{

                    $data_vencimento = date('Y-m-d', strtotime($data_vencimento. ' +'.$dias.' days'));
                    Parcela::create([
                        'id_conta_pagar'=> $conta_pagar->id,
                        'valor_parcela'=> $valor_parcela,
                        'num_parcela' => $i,
                        'data_vencimento'=> $data_vencimento,
                        'status'=> 0
                    ]);
               
                }
            }

            return redirect('contas/despesas');         

        }else{

            $conta_pagar = Despesa::create([
                'id_categoria'=> $despesa['categoria'],
                'id_fornecedor'=> $despesa['fornecedor'],
                'descricao'=> strtoupper($despesa['descricao']),
                'valor'=> $despesa['valor'],
                'valor_pago'=> 0,
                'qtd_parcelas'=> 1,
                'qtd_parcelas_pagas'=> 0
            ]);

            Parcela::create([
                'id_conta_pagar'=> $conta_pagar->id,
                'valor_parcela'=> $despesa['valor'],
                'num_parcela' => 1,
                'data_vencimento'=> $despesa['data_vencimento'],
                'status'=> 0
            ]);

            return redirect('contas/despesas');
        }

    }

    public function detalhes_despesa ($id){

        $parcelas = DB::select("
                SELECT
                    contas_pagar.id as id_conta_pagar,
                    contas_pagar.id_categoria,
                    contas_pagar.id_fornecedor as fornecedor,
                    contas_pagar.descricao,
                    contas_pagar.valor,
                    contas_pagar.valor_pago as total_pago,
                    contas_pagar.qtd_parcelas,
                    contas_pagar.qtd_parcelas_pagas,
                    parcelas.id as id_parcela,
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
                AND contas_pagar.id = '".$id."'
                ORDER BY data_vencimento ASC
            ");

            foreach ($parcelas as $parcela) {

                $id_despesa = $parcela->id_conta_pagar;
                $categoria = $parcela->categoria;
                $descricao = $parcela->descricao;
                $qtd_parcelas = $parcela->qtd_parcelas;
                $qtd_parcelas_pagas = $parcela->qtd_parcelas_pagas;
                $valor_total = $parcela->valor;
                $total_pago = $parcela->total_pago;

                $parcela->data_vencimento = date('d/m/Y', strtotime($parcela->data_vencimento));
                $parcela->data_pagamento = date('d/m/Y', strtotime($parcela->data_pagamento));

                $fornecedores = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, fornecedors
                    WHERE fornecedors.id = '".$parcela->fornecedor."' 
                    AND pessoa_fisicas.id = fornecedors.id_pessoa_fisica
                ");

                if($fornecedores){
                    foreach ($fornecedores as $fornecedor) {
                        $fornecedor = $fornecedor->nome;
                    }
                }else{
                    $fornecedores = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, fornecedors
                        WHERE fornecedors.id = '".$parcela->fornecedor."' 
                        AND pessoa_juridicas.id = fornecedors.id_pessoa_juridica
                    ");

                    foreach ($fornecedores as $fornecedor) {
                        $fornecedor = $fornecedor->nome_fantasia;
                    }
                }

            }

            $formas_pagamento = DB::select("
                SELECT * FROM forma_pagamento");

            return view('contas.contas_despesas_detalhes',compact('id_despesa','categoria','descricao','qtd_parcelas','valor_total','fornecedor','qtd_parcelas_pagas','total_pago','parcelas','formas_pagamento'));
    }

}
