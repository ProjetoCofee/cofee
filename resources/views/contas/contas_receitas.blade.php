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

<!-- <style type="text/css">
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
</style> -->

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
                            columns: [0, 1, 2, 3, 4, 5] // seleciona as colunas que deseja exportar
                        },
                        message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                        title: "Relatório de Receitas Cadastradas",
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
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Receitas Cadastradas"
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
                this.api().columns([0, 1, 2, 5]).every( function () {
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

    window.onload = function() {
        document.getElementById('search').focus();
    };

    function delete_receita(id){

        $('#modal_delete').html('<div align="center"><p>Tem certeza que deseja excluir esta receita?<br>Todas as parcelas também serão excluídas!</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/contas/receitas/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');
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
                            <li class="active"><a href="#">Receitas<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked"> 
                                    <li style = "padding-left: 10px"><a href="/contas/receitas_parcelas?filter=all"> <span class="glyphicon glyphicon-menu-right"></span> Todas parcelas</a></li>
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Contas a receber</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td>
                                        <form class="btn-new" method="get" action="/contas/receitas/novo">
                                            <button type="submit" class="btn btn-primary">Nova Receita</button>
                                        </form>
                                    </td>
                                </table>
                            </div>
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Cliente</th>
                                        <th>Categoria</th>
                                        <th>Valor total (R$)</th>
                                        <th>Parcelas</th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Cliente</th>
                                        <th>Categoria</th>
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
                                            <td>{{number_format($receita->valor, 2, ',', '.')}}</td>
                                            <td>{{$receita->qtd_parcelas}}</td>          
                                            @if($receita->status == '0')
                                            <td>Pendente</td>
                                            @else 
                                            <td>Pago</td>
                                            @endif
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                                @if($receita->qtd_parcelas == '0')
                                                <form class="btn-new" method="get" action="/contas/receitas/parcelas/{{$receita->id}}">
                                                    <button type="submit" class="btn btn-icon" disabled><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </form>
                                                @else
                                                <form class="btn-new" method="get" action="/contas/receitas/parcelas/{{$receita->id}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </form>
                                                @endif
                                                
                                                <button title="Excluir receita" type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_receita('{{$receita->id}}')"><span class="glyphicon glyphicon-trash"></span></button>
                                            </div>
                                            </td>                                           
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
@endsection
