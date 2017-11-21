@extends('layouts.app')
@section('content')

<script src="//code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">

<script type="text/javascript">

    $(document).ready(function() {

        $('#example').dataTable({
            initComplete: function () {
                this.api().columns([0, 3, 4 ,5, 6]).every( function () {
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
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "oLanguage": {
                "sLengthMenu": "Registros por páginas: _MENU_",
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

    function modal_confirmar(id){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_compra_id_detalhes.php',
            data: {busca:id}
        }).done(function(data){
            
            var descricao = data[0].descricao;

            if(data[0].confirmado == '1'){
                var status = "Confirmado";
            }else{
                var status = "Pendente";

                $('#modal_detalhes').html('<div align="center"><p>Confirmar a compra de '+descricao+'?</div><div align="center"><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close" onclick="confirma_compra('+id+')"><span aria-hidden="true">Confirmar compra</span></button><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button></div>'); 
            }              
        });
    }

    function confirma_compra(id){
        
        var id_solicitacao = id;
        var id_usuario_confirma = "<?php print Auth::user()->id ?>";

        $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/confirma_compra_item.php',
                data:{id_solicitacao:id_solicitacao, id_usuario_confirma:id_usuario_confirma}
            }).done(function(){
                location.reload();
            });
    }

</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Estoque</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                            <li><a href="/estoque/show">Estoque<span class="sr-only">(current)</span></a></li>
                            <li><a href="/estoque/historico_entrada">Entrada<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a>Retirada<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked">
                                    <li style = "padding-left: 5px;"><a href="/estoque/retirada"><span class="glyphicon glyphicon-menu-right"></span>   Solicitações retirada</a></li> 
                                    <li class="subactive"><a href="#"><span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span> Solicitações compra</a></li>
                                    <!-- <li style = "padding-left: 5px;"><a href="/estoque/solicita_retirada"> <span class="glyphicon glyphicon-menu-right"></span> Solicitar retirada</a></li> -->
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Solicitações de compra</div>
                        <div class="panel-body">

                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Saldo</th>
                                        <th>Mínimo</th>
                                        <th>Solicitante</th>
                                        <th>Data solicitação</th>
                                        <th>Data confirmação</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tfoot>
                                    <tr>
                                        <th>Produto</th>
                                        <th>--</th>
                                        <th>--</th>
                                        <th>Solicitante</th>
                                        <th>Data solicitação</th>
                                        <th>Data confirmação</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>

                                @if($solicitacoes)
                                    
                                    <tbody>
                                        @foreach($solicitacoes as $solicitacao)
                                        <tr>
                                            <td>{{$solicitacao->descricao}}</td>
                                            <td>{{$solicitacao->saldo}}</td>
                                            <td>{{$solicitacao->minimo}}</td>
                                            <td>{{$solicitacao->solicitante}}</td>
                                            <td>{{$solicitacao->data_solicitacao}}</td>
                                            <td>{{$solicitacao->data_confirmacao}}</td>
                                            <td>@if($solicitacao->confirmado)Confirmado
                                                <div style="display: inline-flex; float: right;">
                                                    <button type="submit" class="btn btn-icon add" disabled><span class="glyphicon glyphicon-ok"></span></button>
                                                </div>
                                                @else Pendente
                                                <div style="display: inline-flex; float: right;">
                                                    <button type="submit" class="btn btn-icon add" data-toggle="modal" data-target="#detail_item" onclick="modal_confirmar('{{$solicitacao->id}}')"><span class="glyphicon glyphicon-ok"></span></button>
                                                </div>
                                                @endif</td>
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
                <div class="panel-heading" align="center">Detalhes da solicitação</div>
                <div class="panel-body">
                    <div id="modal_detalhes" class="modal-body" style="color: #1E3973;">
                    <!-- conteudo js -->
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

@endsection
