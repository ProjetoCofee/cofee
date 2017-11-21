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
                this.api().columns([0, 1, 2, 3]).every( function () {
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

    function formatar_Data(data, tipo){
        var d = new Date(data),
        ano = ''  +  d.getFullYear(),
        mes = ''  + (d.getMonth() + 1),
        dia = ''  +  d.getDate(),
        hora = '' +  d.getHours(),
        min = ''  +  d.getMinutes();

        if(mes.length  < 2) mes  = '0' + mes;
        if(dia.length  < 2) dia  = '0' + dia;
        if(hora.length < 2) hora = '0' + hora;
        if(min.length  < 2) min  = '0' + min;

        if(tipo == 'nasc') return [dia, mes, ano].join('/');

        return [dia, mes, ano].join('/') + " Horas: " + [hora, min].join(':');
    }

    function detalhes_produto(id){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_produto_id_detalhes.php',
            data: {busca:id}
        }).done(function(data){
            var id = data[0].id;
            var codigo_barras = data[0].codigo_barras;
            var descricao = data[0].descricao;
            var saldo = data[0].saldo;
            var unidade_medida = data[0].unidade_medida;
            var posicao = data[0].posicao;
            var corredor = data[0].corredor;
            var prateleira = data[0].prateleira;
            var minimo = data[0].minimo;
            var observacao = data[0].observacao;
            var created_at = formatar_Data(data[0].created_at);
            var updated_at = formatar_Data(data[0].updated_at);
            var nome_marca = data[0].nome_marca;
            var nome_departamento = data[0].nome_departamento;

            $('#modal_detalhes').html('<div class="container"><div class="center-block" style="margin-left: 5%;"><table><td><th style="float: right">Código:</th></td><td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;">'+codigo_barras+'</td><tr><td><th style="float: right">Descrição:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+descricao+'</td><tr><td><th style="float: right">Marca:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+nome_marca+'</td><tr><td><th style="float: right">Departamento:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+nome_departamento+'</td><tr><td><th style="float: right">Saldo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+saldo+' '+unidade_medida+'</td><tr><td><th style="float: right">Mínimo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+minimo+' '+unidade_medida+'</td><tr><td><th style="float: right">Posição:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+posicao+'</td><tr><td><th style="float: right">Corredor:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+corredor+'</td><tr><td><th style="float: right">Prateleira:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+prateleira+'</td><tr><td><th style="float: right">Observação:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+observacao+'</td><tr><td><th style="float: right">Criado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+created_at+'</td><tr><td><th style="float: right">Alterado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+updated_at+'</td></table></div>');    
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
                            <li class="active"><a href="#">Estoque<span class="sr-only">(current)</span></a></li>
                            <li><a href="/estoque/historico_entrada">Entrada<span class="sr-only">(current)</span></a></li>
                            <li><a href="/estoque/retirada">Retirada<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Produtos em estoque</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>

                                </table>
                            </div>
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                        <th>Marca</th>
                                        <th>Departamento</th>
                                        <th>Saldo</th>
                                        <th>Un. Medida</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Marca</th>
                                        <th>Departamento</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                @if($produtos)
                                    <tbody>
                                        @foreach($produtos as $produto)
                                        <tr>
                                            <td>{{$produto->codigo_barras}}</td>
                                            <td>{{$produto->descricao}}</td>
                                            <td>{{$produto->nome_marca}}</td>
                                            <td>{{$produto->nome_departamento}}</td>
                                            <td>{{$produto->saldo}}</td>
                                            <td>{{$produto->unidade_medida}}</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;"><button type="submit" class="btn btn-icon" data-toggle="modal" data-target="#detail_item" onclick="detalhes_produto('{{$produto->id}}')"><span class="glyphicon glyphicon-eye-open"></span></button></div>
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

<div class="modal fade" id="detail_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Detalhes do produto</div>
                <div class="panel-body">
                    <div id="modal_detalhes" class="modal-body" style="color: #1E3973;">
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

@endsection
