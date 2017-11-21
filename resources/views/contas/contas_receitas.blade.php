@extends('layouts.app')

@section('content')

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
                                    <li style = "padding-left: 10px"><a href="/contas/receitas_parcelas"> <span class="glyphicon glyphicon-menu-right"></span>  Todas parcelas</a></li>
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
                                    <td style="padding-bottom: 1em;">
                                    <form method="post" action="/contas/receitas/busca" class="form-inline" role="search">
                                        <div class="form-group">
                                            <input type="text" id="search" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Data, valor, fornecedor ou categoria" autofocus="true">
                                        </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="get" action="/contas/receitas" class="form-inline">
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
                                        <th>Valor total (R$)</th>
                                        <th>Parcelas</th>
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
                                            <td>{{$receita->valor}}</td>
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
@endsection
