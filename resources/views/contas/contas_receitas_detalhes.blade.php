@extends('layouts.app2')

@section('content')

<script type="text/javascript">

    function confirmar_pagamento(id_parcela,id_conta_receber,data_vencimento){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_receita_id_detalhes.php',
            data: {busca:id_parcela}
        }).done(function(data){
console.log(data);
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
            var hoje = "<?php print date("Y-m-d") ?>";

           $('#modal_pagamento').html('<form class="form-horizontal"><div class="form-group"><label for="descricao" class="col-md-4 control-label">Descrição</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="descricao" type="text" class="form-control" name="descricao" value="'+descricao+'" readonly>            </div>            <label for="num_parcela" class="col-md-4 control-label">Nº Parcela</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="num_parcela" type="text" class="form-control number" name="num_parcela" value="'+num_parcela+'" readonly>            </div>            <label for="valor_parcela" class="col-md-4 control-label">Valor parcela (R$)</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="valor_parcela" type="number" min="0,01" step="any" class="form-control number" name="valor_parcela" value="'+valor_parcela+'" readonly>            </div>            <label for="data_vencimento" class="col-md-4 control-label">Vencimento</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="data_vencimento" type="text" class="form-control" name="data_vencimento" value="'+data_vencimento+'" readonly>            </div>        <label for="data_pagamento" class="col-md-4 control-label">Pagamento</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="data_pagamento" type="date" class="form-control" name="data_pagamento" value="'+hoje+'">            </div>        <label for="forma_pagamento" class="col-md-4 control-label">Forma de pagamento</label><div class="col-md-6" style="padding-bottom: 1em;"><select id="forma_pagamento" name="forma_pagamento" class="form-control" autocomplete="autofocus" required><option value="DINHEIRO">DINHEIRO</option><option value="CREDITO">CRÉDITO</option><option value="DEBITO">DÉBITO</option><option value="CHEQUE">CHEQUE</option></select></div>        </div></form><div align="center"><button id="btn_salvar" type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close" onclick="salvar_pagamento('+id_parcela+','+id_conta_receber+')"><span aria-hidden="true">Salvar</span></button><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button></div>');
        });
    }

    function salvar_pagamento(id_parcela, id_conta_receber){

        var forma_pagamento = document.getElementById('forma_pagamento').value;
        var data_pagamento = document.getElementById('data_pagamento').value;
        var valor_pago = parseFloat(document.getElementById('valor_parcela').value);
        var status = 0;
        var qtd_parcelas = parseInt("<?php print $qtd_parcelas ?>");
        var qtd_parcelas_pagas = parseInt("<?php print $qtd_parcelas_pagas ?>")+1;

        if(qtd_parcelas == qtd_parcelas_pagas){
            var status = 1;
        }

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/confirma_pagamento_receita.php',
            data:{  forma_pagamento : forma_pagamento,
                    data_pagamento : data_pagamento,
                    valor_pago : valor_pago,
                    id_parcela : id_parcela,
                    id_conta_receber : id_conta_receber,
                    status : status
                }
        }).done(function(data){
            location.reload();
        });
    }

    function cancelar_pagamento(id_parcela, id_conta_receber, valor_pago){

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/cancela_pagamento_receita.php',
            data:{  valor_pago : valor_pago,
                    id_parcela : id_parcela,
                    id_conta_receber : id_conta_receber
                }
        }).done(function(data){
            location.reload();
        });
    }

    function update_parcela(id_parcela,id_conta_receber){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_receita_id_detalhes.php',
            data: {busca:id_parcela}
        }).done(function(data){
            var categoria = data[0].categoria;
            var data_pagamento = data[0].data_pagamento;
            var data_vencimento = data[0].data_vencimento;
            var descricao = data[0].descricao;
            var cliente = data[0].cliente;
            var forma_pagamento = data[0].id_forma_pagamento;
            var num_parcela = data[0].num_parcela;
            var qtd_parcelas = data[0].qtd_parcelas;
            var qtd_parcelas_pagas = data[0].qtd_parcelas_pagas;
            var valor = data[0].valor;
            var valor_pago = data[0].valor_pago;
            var valor_parcela = data[0].valor_parcela;

            $('#modal_update').html('<form class="form-horizontal"><div class="form-group"><label for="num_parcela" class="col-md-4 control-label">Nº Parcela</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="num_parcela" type="text" class="form-control number" name="num_parcela" value="'+num_parcela+'" readonly></div><label for="data_vencimento" class="col-md-4 control-label">Vencimento</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="data_vencimento" type="date" class="form-control" name="data_vencimento" value="'+data_vencimento+'" required></div><label for="valor_parcela" class="col-md-4 control-label">Valor parcela (R$)</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="valor_parcela" type="number" min="0,01" step="any" class="form-control number dinheiro" name="valor_parcela" value="'+valor_parcela+'" required></div></div></div></form><div align="center"><button id="btn_salvar" type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close" onclick="salvar_update('+id_parcela+')"><span aria-hidden="true">Salvar</span></button><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button></div>');
        });
    }

    function salvar_update(id_parcela){

        var data_vencimento = document.getElementById('data_vencimento').value;
        var valor_parcela = parseFloat(document.getElementById('valor_parcela').value);

        $.ajax({
        dataType: 'json',
        type:'POST',
        url: url+'api/confirma_update_parcela_receita.php',
        data:{  id_parcela : id_parcela,
                data_vencimento : data_vencimento,
                valor_parcela : valor_parcela
            }
        }).done(function(data){
            location.reload();
        });
    }

    function delete_parcela(id){

        $('#modal_delete').html('<div align="center"><p>Tem certeza que deseja excluir esta parcela?</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/contas/receitas_parcelas/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');    
    }

</script>

<style type="text/css">
    label {
        text-align: right;
    }
    td{
        margin-bottom: 1em; 
    }
</style>

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
                                    <li style = "padding-left: 10px"><a href="/contas/receitas_parcelas?filter=all"> <span class="glyphicon glyphicon-menu-right"></span>  Todas parcelas</a></li>
                                    <li class="active" style = "padding-left: 10px"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span>  Detalhes</a></li>
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detalhes da receita</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="text-align: right; min-width: 150px;">Nº receita</label>
                                        <div class="col-md-6">
                                            <input class="form-control number" type="text" value="{{$id_receita}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="text-align: right;min-width: 180px;">Categoria</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$categoria}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="text-align: right;min-width: 150px;">Descrição</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$descricao}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="text-align: right;min-width: 180px;">Cliente</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$cliente}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="text-align: right;min-width: 150px;">Qtd. Parcelas</label>
                                        <div class="col-md-6">
                                            <input class="form-control number" type="text" value="{{$qtd_parcelas}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="text-align: right;min-width: 180px;">Valor despesa (R$)</label>
                                        <div class="col-md-6">
                                            <input type="text" step="any" class="form-control number" type="text" value="{{$valor_total}}" readonly style="text-align: right;min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="text-align: right;min-width: 150px;">Parcelas pagas</label>
                                        <div class="col-md-6">
                                            <input class="form-control number" type="text" value="{{$qtd_parcelas_pagas}}" readonly style="text-align: right;min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="text-align: right;min-width: 180px;">Valor pago (R$)</label>
                                        <div class="col-md-6">
                                            <input type="text" step="any" class="form-control number" type="text" value="{{$total_pago}}" readonly style="text-align: right;min-width: 200px;">
                                        </div>
                                    </td>
                                </table>
                            </div>
                            <TABLE class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Parcela</th>
                                        <th>Valor (R$)</th>
                                        <th>Data venc.</th>
                                        <th>Data pagam.</th>
                                        <th>Forma pagam.</th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($parcelas)
                                    @foreach($parcelas as $parcela)
                                    <tbody>
                                        <tr>
                                            <td>{{$count++."/".$parcela->qtd_parcelas}}</td>
                                            <td>{{number_format($parcela->valor_parcela, 2, ',', '.')}}</td>
                                            <td>{{$parcela->data_vencimento}}</td>
                                            
                                            @if($parcela->status == '0')
                                            <td></td>
                                            <td></td>
                                            <td>PENDENTE</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                                <button title="Confirmar pagamento" type="submit" class="btn btn-icon add" data-toggle="modal" data-target="#confirm_item" onclick="confirmar_pagamento('{{$parcela->id_parcela}}','{{$parcela->id_conta_receber}}','{{$parcela->data_vencimento}}')"><span class="glyphicon glyphicon-ok"></span></button>

                                                <button title="Editar parcela" type="submit" class="btn btn-icon" data-toggle="modal" data-target="#update_item" onclick="update_parcela('{{$parcela->id_parcela}}','{{$parcela->id_conta_receber}}','pendente')"><span class="glyphicon glyphicon-pencil"></span></button>

                                                @if($qtd_parcelas > 1)
                                                <button title="Excluir parcela" type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_parcela('{{$parcela->id_parcela}}')"><span class="glyphicon glyphicon-trash"></span></button>
                                                @else
                                                <button title="Excluir parcela" type="submit" class="btn btn-icon remove" disabled><span class="glyphicon glyphicon-trash"></span></button>
                                                @endif
                                                
                                            </div>
                                            </td>

                                            @else 
                                            <td>{{$parcela->data_pagamento}}</td>
                                            <td>{{$parcela->id_forma_pagamento}}</td>
                                            <td>PAGO</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                                <button title="Cancelar pagamento" type="submit" class="btn btn-icon remove" onclick="cancelar_pagamento('{{$parcela->id_parcela}}','{{$parcela->id_conta_receber}}','{{$parcela->valor_pago}}')"><span class="glyphicon glyphicon-remove"></span></button>

                                                <button title="Editar parcela" type="submit" class="btn btn-icon" data-toggle="modal" data-target="#update_item" disabled><span class="glyphicon glyphicon-pencil"></span></button>

                                                <button title="Excluir parcela" type="submit" class="btn btn-icon remove" disabled><span class="glyphicon glyphicon-trash"></span></button>
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

<div class="modal fade" id="delete_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Atenção!</div>
                <div class="panel-body">
                    <div id="modal_delete" class="modal-body" style="color: #1E3973;">
                    <!-- conteudo js -->
                    </div>
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
<div class="modal fade" id="update_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Editar parcela</div>
                <div class="panel-body">
                    <div id="modal_update" class="modal-body" style="color: #1E3973;">
                    <!-- conteudo js -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
