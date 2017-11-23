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
                this.api().columns([0, 1]).every( function () {
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

    function delete_departamento(id,nome){

        // $('#modal_delete').html('<div align="center"><p>Tem certeza que deseja excluir o departamento "'+nome+'"?</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/cadastro/departamento/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');    
        $('span.nome').text(nome);
        document.getElementById('delete').action = "/cadastro/departamento/" + id + "/delete";
    }
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                        <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a>
                            <ul class="nav nav-pills nav-stacked"> 
                                <li style = "padding-left: 10px" class="active"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span>  Departamento</a></li> 
                                <li style = "padding-left: 10px "><a href="/cadastro/marca"> <span class="glyphicon glyphicon-menu-right"></span> Marca</a></li> 
                            </ul>
                        </li>
                        <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                        <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Departamentos<div style="float: right; font-size: 17pt;"><a target="_blank" href="/cadastro/departamento/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="/cadastro/departamento/cadastrar">
                                            <button type="submit" class="btn btn-primary"><span style="color: white" class="glyphicon glyphicon-plus"></span> Novo</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Nome</th>
                                        <th style="text-align: right; padding-right: 1.6em">Opções</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>Número</th>
                                        <th>Nome</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                
                                <tbody>
                                    @if($departamentos)
                                    @foreach($departamentos as $departamento)
                                    <tr>
                                        <td>{{$departamento->id}}</td>
                                        <td>{{$departamento->nome}}</td>
                                        <td>
                                            <div style="display: inline-flex; float: right;">
                                                <form method="GET" action="/cadastro/departamento/{{$departamento->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>

                                                <button type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_departamento('{{$departamento->id}}','{{$departamento->nome}}')"><span class="glyphicon glyphicon-trash"></span></button>
                                            </div>
                                        </td>                                      
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                
                            </TABLE>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<form method="GET" id="delete">
    <div class="modal fade" id="delete_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Atenção!</div>
                    <div class="panel-body">
                        <div id="modal_delete" class="modal-body" style="color: #1E3973;">
                            <div align="center">
                                <p>Tem certeza que deseja excluir o departamento <span class="nome"></span>?</p>
                            </div>
                            <br><br>
                            <div align="center">
                                <table>
                                    <tr>
                                        <td>
                                            <button type="submit" class="btn crud-submit btn-primary remove">Excluir</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">Cancelar</span>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</form>


@endsection
