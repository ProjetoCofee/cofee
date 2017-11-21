@extends('layouts.app')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('search').focus();
    };

     function confirmar_pagamento(id,id_conta_pagar,data_vencimento){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_despesa_id_detalhes.php',
            data: {busca:id}
        }).done(function(data){
            
            var categoria = data[0].categoria;
            var data_pagamento = data[0].data_pagamento;
            var descricao = data[0].descricao;
            var cliente = data[0].cliente;
            var forma_pagamento = data[0].id_forma_pagamento;
            var num_parcela = data[0].num_parcela;
            var qtd_parcelas = data[0].qtd_parcelas;
            var qtd_parcelas_pagas = data[0].qtd_parcelas_pagas;
            if(data[0].status=='0')
                var status = 'Pendente';
            else if(data[0].status=='1')
                var status = 'Pago';
            var valor = data[0].valor;
            var valor_pago = data[0].valor_pago;
            var valor_parcela = data[0].valor_parcela;

            $('#modal_pagamento').html('<form class="form-horizontal"><div class="form-group">            <label for="num_parcela" class="col-md-4 control-label">Nº Parcela</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="num_parcela" type="text" class="form-control number" name="num_parcela" value="'+num_parcela+'" readonly>            </div>            <label for="descricao" class="col-md-4 control-label">Descrição</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="descricao" type="text" class="form-control" name="descricao" value="'+descricao+'" readonly>            </div><label for="valor_parcela" class="col-md-4 control-label">Valor parcela (R$)</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="valor_parcela" type="number" min="0,01" step="any" class="form-control number" name="valor_parcela" value="'+valor_parcela+'" readonly>            </div>            <label for="data_vencimento" class="col-md-4 control-label">Vencimento</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="data_vencimento" type="text" class="form-control" name="data_vencimento" value="'+data_vencimento+'" readonly>            </div>        <label for="forma_pagamento" class="col-md-4 control-label">Forma de pagamento</label><div class="col-md-6" style="padding-bottom: 1em;"><select id="forma_pagamento" name="forma_pagamento" class="form-control" autocomplete="autofocus" required><option value="A VISTA">À VISTA</option><option value="CREDITO">CRÉDITO</option><option value="DEBITO">DÉBITO</option><option value="CHEQUE">CHEQUE</option></select></div>        </div></form><div align="center"><button id="btn_salvar" type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close" onclick="salvar_pagamento('+id+','+id_conta_pagar+','+qtd_parcelas+','+qtd_parcelas_pagas+')"><span aria-hidden="true">Salvar</span></button><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button></div>');
        });
    }

    // function calcula_valor(){

    //     var valor_parcela =  parseInt(document.getElementById('valor_parcela').value);
    //     var valor_pago =  parseInt(document.getElementById('valor_pago').value);
    //     var forma_pagamento = document.getElementById('valor_pago').value;

    //     if(valor_pago == ''||forma_pagamento == ''){
    //         document.getElementById("btn_salvar").disabled = true; 
    //     }else if(valor_pago>valor_parcela || valor_pago<=0){
    //         document.getElementById("btn_salvar").disabled = true; 
    //     }else{
    //         document.getElementById("btn_salvar").disabled = false;
    //     }
    // }

    function salvar_pagamento(id_parcela, id_conta_pagar, qtd_parcelas, qtd_parcelas_pagas){

        var forma_pagamento = document.getElementById('forma_pagamento').value;
        var valor_pago = parseInt(document.getElementById('valor_parcela').value);
        var status = 0;
        var qtd_parcelas_pagas = qtd_parcelas_pagas+1;

        if(qtd_parcelas == qtd_parcelas_pagas){
            var status = 1;
        }

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/confirma_pagamento_despesa.php',
            data:{  forma_pagamento : forma_pagamento, 
                    valor_pago : valor_pago,
                    id_parcela : id_parcela,
                    id_conta_pagar : id_conta_pagar,
                    status : status
                }
        }).done(function(data){
            location.reload();
        });
    }

    function cancelar_pagamento(id_parcela, id_conta_pagar, valor_pago){

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/cancela_pagamento_despesa.php',
            data:{  valor_pago : valor_pago,
                    id_parcela : id_parcela,
                    id_conta_pagar : id_conta_pagar
                }
        }).done(function(data){
            location.reload();
        });
    }

</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Contas</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                            <li><a href="/contas/resumo">Resumo<span class="sr-only">(current)</span></a></li>
                            <li><a href="/contas/despesas">Despesas<span class="sr-only">(current)</span></a>
                            </li>
                            <li><a href="/contas/receitas">Receitas<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked"> 
                                    <li class="active" style = "padding-left: 10px"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span>  Todas parcelas</a></li>
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Parcelas de receitas</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td style="padding-bottom: 1em;">
                                    <form method="post" action="/contas/receitas/busca" class="form-inline" role="search">
                                        <div class="form-group">
                                            <input type="text" id="search" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Data, valor, cliente ou categoria" autofocus="true">
                                        </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="get" action="/contas/receitas_parcelas" class="form-inline">
                                        <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Cliente</th>
                                        <th>Categoria</th>
                                        <th>Valor</th>
                                        <th>Valor total</th>
                                        <th>Parcelas</th>
                                        <th>Data venc.</th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($receitas)
                                    @foreach($receitas as $receita)
                                    <tbody>
                                        <tr>
                                            <td>{{$receita->descricao}}</td>
                                            <td>{{$receita->cliente}}</td>
                                            <td>{{$receita->categoria}}</td>
                                            <td>{{$receita->valor_parcela}}</td>
                                            <td>{{$receita->valor}}</td>
                                            <td>{{$receita->num_parcela."/".$receita->qtd_parcelas}}</td>
                                            <td>{{$receita->data_vencimento}}</td>
                                             
                                            @if($receita->status == '0')
                                            <td>PENDENTE</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                                <form class="btn-new" method="get" action="/contas/receitas/parcelas/{{$receita->id_conta_pagar}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </form>
                                                <button type="submit" class="btn btn-icon add" data-toggle="modal" data-target="#confirm_item" onclick="confirmar_pagamento('{{$receita->id_parcela}}','{{$receita->id_conta_pagar}}','{{$receita->data_vencimento}}')"><span class="glyphicon glyphicon-ok"></span></button>
                                            </div>
                                            </td>

                                            @else 
                                            <td>PAGO</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                                <form class="btn-new" method="get" action="/contas/receitas/parcelas/{{$receita->id_conta_pagar}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </form>
                                                <button title="Cancelar pagamento" type="submit" class="btn btn-icon remove" onclick="cancelar_pagamento('{{$receita->id_parcela}}','{{$receita->id_conta_pagar}}','{{$receita->valor_pago}}')"><span class="glyphicon glyphicon-remove"></span></button>
                                            </div>
                                            </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                    @endforeach
                                @endif
                            </TABLE>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="detail_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Detalhes da despesa</div>
                <div class="panel-body">
                    <div id="modal_detalhes_despesa" class="modal-body" style="color: #1E3973;">
                    <!-- conteudo js -->
                    </div>
                </div>
                <div align="center">
                    <button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Confirmar pagamento</div>
                <div class="panel-body">
                    <div id="modal_pagamento" class="modal-body" style="color: #1E3973;">
                    <!-- conteudo js -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
