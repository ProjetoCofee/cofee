@extends('layouts.app')
@section('content')

<script src="//code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
        overflow: auto;
    }
</style>

<script type="text/javascript">

    $(document).ready(function() {

        $('#example').dataTable({
            dom: 'Bfrtip',

            buttons: [
                {
                        // exporta em PDF
                        // extend: 'pdf',
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o" style="font-size: 18px; color: #CD0000"></i>',
                        titleAttr: 'Exportar para PDF',
                        orientation: 'portrait', //landscape = paisagem | portrait = retrato
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // seleciona as colunas que deseja exportar
                        },
                        message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                        title: "Relatório de Todas as Parcelas das Receitas",
                        customize: function(doc) {
                            doc.defaultStyle.alignment = 'center';
                            doc.styles.tableHeader.alignment = 'center';
                        }

                },

                {
                    // exporta em excel
                    extend: 'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o" style="font-size: 18px; color: green"></i>',
                    titleAttr: 'Exportar para Excel',
                    orientation: 'portrait', //landscape = paisagem | portrait = retrato
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Todas as Parcelas das Receitas"
                },

                'pageLength',
            ],

            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 registros', '25 registros', '50 registros', 'Mostrar Todos' ]
            ],

            stateSave: false,
            fixedHeader: true, // para congelar os titulos quando rolar o relatório para baixo

            initComplete: function () {
                this.api().columns([1, 2, 7]).every( function () {
                    var column = this;
                    var title = $(this).text();
                    var select = $('<select><option value="">Mostrar Todos</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                            );

                        column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                    } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            },

            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "oLanguage": {
                buttons: {
                    pageLength: {
                       _: "Mostrando %d Registros",
                       '-1': "Mostrando Todos"
                   }
                },
                "sZeroRecords": "Nenhum registro encontrado",
                "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
                "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros)",
                "sSearch": "Pesquisar: ",
                "oPaginate": {
                    "sFirst": "Início",
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sLast": "Último"
                }
            },
        });  
    });
</script>

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

            $('#modal_pagamento').html('<form class="form-horizontal"><div class="form-group"><label for="descricao" class="col-md-4 control-label">Descrição</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="descricao" type="text" class="form-control" name="descricao" value="'+descricao+'" readonly>            </div>            <label for="num_parcela" class="col-md-4 control-label">Nº Parcela</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="num_parcela" type="text" class="form-control number" name="num_parcela" value="'+num_parcela+'" readonly>            </div>            <label for="valor_parcela" class="col-md-4 control-label">Valor parcela (R$)</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="valor_parcela" type="number" min="0,01" step="any" class="form-control number" name="valor_parcela" value="'+valor_parcela+'" readonly>            </div>            <label for="data_vencimento" class="col-md-4 control-label">Vencimento</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="data_vencimento" type="text" class="form-control" name="data_vencimento" value="'+data_vencimento+'" readonly>            </div>        <label for="data_pagamento" class="col-md-4 control-label">Pagamento</label>            <div class="col-md-6" style="padding-bottom: 1em;">                <input id="data_pagamento" type="date" class="form-control" name="data_pagamento" value="'+hoje+'">            </div>        <label for="forma_pagamento" class="col-md-4 control-label">Forma de pagamento</label><div class="col-md-6" style="padding-bottom: 1em;"><select id="forma_pagamento" name="forma_pagamento" class="form-control" autocomplete="autofocus" required><option value="DINHEIRO">DINHEIRO</option><option value="CREDITO">CRÉDITO</option><option value="DEBITO">DÉBITO</option><option value="CHEQUE">CHEQUE</option></select></div>        </div></form><div align="center"><button id="btn_salvar" type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close" onclick="salvar_pagamento('+id_parcela+','+id_conta_receber+','+qtd_parcelas+','+qtd_parcelas_pagas+')"><span aria-hidden="true">Salvar</span></button><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button></div>');
        });
    }

    function salvar_pagamento(id_parcela, id_conta_receber, qtd_parcelas, qtd_parcelas_pagas){

        var forma_pagamento = document.getElementById('forma_pagamento').value;
        var data_pagamento = document.getElementById('data_pagamento').value;
        var valor_pago = parseFloat(document.getElementById('valor_parcela').value);
        var status = 0;
        var qtd_parcelas_pagas = qtd_parcelas_pagas+1;

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
                            <li class="active"><a href="/contas/receitas">Receitas<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked"> 
                                    <li class="subactive" style = "padding-left: 10px"><a href="#"> <span class="glyphicon glyphicon-triangle-right"></span>  Todas parcelas</a></li>
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
                                    <td>
                                        <select name="tipo" class="form-control" onchange="location = '/contas/receitas_parcelas?filter='+this.value;" style="margin-bottom: 1em;">
                                            <option value="{{$filter}}">Escolha vencimento</option>
                                            <option value="all">Todas</option>
                                            <option value="intime">Pendentes no prazo</option>
                                            <option value="timeout">Pendentes atrasadas</option>
                                        </select>
                                    </td>
                                </table>
                            </div>
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Cliente</th>
                                        <th>Categoria</th>
                                        <th>Valor parc.</th>
                                        <th>Valor desp.</th>
                                        <th>Parcelas</th>
                                        <th>Data venc.</th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Cliente</th>
                                        <th>Categoria</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                                @if($receitas)
                                    <tbody>
                                        @foreach($receitas as $receita)
                                        <tr>
                                            <td>{{$receita->descricao}}</td>
                                            <td>{{$receita->cliente}}</td>
                                            <td>{{$receita->categoria}}</td>
                                            <td>{{number_format($receita->valor_parcela, 2, ',', '.')}}</td>
                                            <td>{{number_format($receita->valor, 2, ',', '.')}}</td>
                                            <td>{{$receita->num_parcela."/".$receita->qtd_parcelas}}</td>
                                            <td>{{$receita->data_vencimento}}</td>
                                             
                                            @if($receita->status == '0')
                                            <td>PENDENTE</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                                <form class="btn-new" method="get" action="/contas/receitas/parcelas/{{$receita->id_conta_receber}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </form>
                                                <button type="submit" class="btn btn-icon add" data-toggle="modal" data-target="#confirm_item" onclick="confirmar_pagamento('{{$receita->id_parcela}}','{{$receita->id_conta_receber}}','{{$receita->data_vencimento}}')"><span class="glyphicon glyphicon-ok"></span></button>
                                            </div>
                                            </td>

                                            @else 
                                            <td>PAGO</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                                <form class="btn-new" method="get" action="/contas/receitas/parcelas/{{$receita->id_conta_receber}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </form>
                                                <button title="Cancelar pagamento" type="submit" class="btn btn-icon remove" onclick="cancelar_pagamento('{{$receita->id_parcela}}','{{$receita->id_conta_receber}}','{{$receita->valor_pago}}')"><span class="glyphicon glyphicon-remove"></span></button>
                                            </div>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
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
