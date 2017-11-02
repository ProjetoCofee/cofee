@extends('layouts.app')

@section('content')

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
                                    <li class="subactive"><a href="/estoque/retirada"> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Solicitações retirada</a></li> 
                                    <li style = "padding-left: 5px;"><a href="/estoque/compra"> <span class="glyphicon glyphicon-menu-right"></span> Solicitações compra</a></li>
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Entrada de produtos</div>
                        <div class="panel-body">

                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Nº entrada</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$id_entrada}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Data entrada</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$data_entrada}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Responsável</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$responsavel}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    @if($serie_nf)
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Fornecedor</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$fornecedor}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Série nota fiscal</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$serie_nf}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Nº nota fiscal</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$num_nota_fiscal}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    @elseif($motivo)
                                    <td colspan="2" style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Motivo</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$motivo}}" readonly style="min-width: 350px;">
                                        </div>
                                    </td>
                                    @endif
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código barras</th>
                                        <th>Descrição</th>
                                        <th>Saldo</th>
                                        <th>Un. Medida</th>
                                        <th>Quantidade</th>
                                        <th></th>
                                    </tr>
                                </thead>
                             @if($entradas)
                                    @foreach($entradas as $entrada)
                                    <tbody>
                                        <tr>
                                            <td>{{$entrada->codigo_barras}}</td>
                                            <td>{{$entrada->descricao}}</td>
                                            <td>{{$entrada->saldo}}</td>
                                            <td>{{$entrada->unidade_medida}}</td>
                                            <td>{{$entrada->quantidade}}</td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                @endif
                            </TABLE>

                            <div align="center">
                                <button class="btn btn-primary" type="button" onclick="history.go(-1)">
                                    Voltar
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
