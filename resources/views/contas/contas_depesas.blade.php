@extends('layouts.app')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('search').focus();
    };

    function delete_despesa(id){

        $('#modal_delete').html('<div align="center"><p>Tem certeza que deseja excluir esta despesa?<br>Todas as parcelas também serão excluídas!</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/contas/despesas/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');
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
                            <li class="active"><a href="#">Despesas<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked"> 
                                    <li style = "padding-left: 10px"><a href="/contas/despesas_parcelas?filter=all"> <span class="glyphicon glyphicon-menu-right"></span> Todas parcelas</a></li>
                                </ul>
                            </li>
                            <li><a href="/contas/receitas">Receitas<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Contas a pagar</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td>
                                        <form class="btn-new" method="get" action="/contas/despesas/novo">
                                            <button type="submit" class="btn btn-primary">Nova Despesa</button>
                                        </form>
                                    </td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="post" action="/contas/despesas/busca" class="form-inline" role="search">
                                        <div class="form-group">
                                            <input type="text" id="search" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Data, valor, fornecedor ou categoria" autofocus="true">
                                        </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="get" action="/contas/despesas" class="form-inline">
                                        <button type="submit" class="btn btn-icon" style="margin-right: 1em;"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Fornecedor</th>
                                        <th>Categoria</th>
                                        <th>Valor total (R$)</th>
                                        <th>Parcelas</th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($despesas)
                                    @foreach($despesas as $despesa)
                                    <tbody>
                                        <tr>
                                            <td>{{$despesa->descricao}}</td>
                                            <td>{{$despesa->fornecedor}}</td>
                                            <td>{{$despesa->categoria}}</td>
                                            <td>{{number_format($despesa->valor, 2, ',', '.')}}</td>
                                            <td>{{$despesa->qtd_parcelas}}</td>          
                                            @if($despesa->status == '0')
                                            <td>Pendente</td>
                                            @else 
                                            <td>Pago</td>
                                            @endif
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                                @if($despesa->qtd_parcelas == '0')
                                                <form class="btn-new" method="get" action="/contas/despesas/parcelas/{{$despesa->id}}">
                                                    <button type="submit" class="btn btn-icon" disabled><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </form>
                                                @else
                                                <form class="btn-new" method="get" action="/contas/despesas/parcelas/{{$despesa->id}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </form>
                                                @endif
                                                
                                                <button title="Excluir despesa" type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_despesa('{{$despesa->id}}')"><span class="glyphicon glyphicon-trash"></span></button>
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
