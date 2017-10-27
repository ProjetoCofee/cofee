@extends('layouts.app')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('search').focus();
    };

    function detalhes_entrada(id){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_entrada_id_detalhes.php',
            data: {busca:id}
        }).done(function(data){

            var id = data[0].id;
            var motivo = data[0].motivo;
            var fornecedor = data[0].fornecedor;
            var responsavel = data[0].responsavel;
            var serie_nf = data[0].serie_nf;
            var num_nota_fiscal = data[0].num_nota_fiscal;
            var data_entrada = data[0].data_entrada;
            var created_at = data[0].created_at;
            var updated_at = data[0].updated_at;

            if(serie_nf){
                $('#modal_detalhes').html('<div class="container"><div class="center-block" style="margin-left: 5%;"><table><td><th style="float: right">Nº entrada:</th></td><td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;">'+id+'</td><tr><td><th style="float: right">Responsável:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+responsavel+'</td><tr><td><th style="float: right">Fornecedor:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+fornecedor+'</td><tr><td><th style="float: right">Série NF:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+serie_nf+'</td><tr><td><th style="float: right">Nº nota fiscal:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+num_nota_fiscal+'</td><tr><td><th style="float: right">Data da entrada:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+data_entrada+'</td><tr><td><th style="float: right">Criado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+created_at+'</td><tr><td><th style="float: right">Alterado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+updated_at+'</td></table></div>'); 
            }else if(motivo){
                $('#modal_detalhes').html('<div class="container"><div class="center-block" style="margin-left: 5%;"><table><td><th style="float: right">Nº entrada:</th></td><td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;">'+id+'</td><tr><td><th style="float: right">Responsável:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+responsavel+'</td><tr><td><th style="float: right">Motivo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+motivo+'</td><tr><td><th style="float: right">Data da entrada:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+data_entrada+'</td><tr><td><th style="float: right">Criado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+created_at+'</td><tr><td><th style="float: right">Alterado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+updated_at+'</td></table></div>');
            } else{
                $('#modal_detalhes').html('');
            }              
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
                        <li><a href="/estoque/show">Estoque<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Entrada<span class="sr-only">(current)</span></a></li>
                            <ul class="nav nav-pills nav-stacked">
                                <li class="subactive"><a href="#"> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Histórico entradas</a></li>
                            </ul>
                        <li><a href="/estoque/retirada">Retirada<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Entradas de produto</div>
                        <div class="panel-body">

                            <div style="float: left;">
                                <table>
                                    <td><a href="/estoque/entrada"><button type="submit" class="btn btn-primary">Nova entrada</button></td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="post" action="/estoque/entrada/busca" class="form-inline" role="search">
                                        <div class="form-group">
                                            <input type="text" name="search" id="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Número ou responsável" autofocus="true" autocomplete="off">
                                        </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="get" action="/estoque/historico_entrada" class="form-inline">
                                        <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nº entrada</th>
                                        <th>Responsável</th>
                                        <th>Data</th>
                                        <th>Tipo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($entradas)
                                    @foreach($entradas as $entrada)
                                    <tbody>
                                        <tr>
                                            <td>{{$entrada->id}}</td>
                                            <td>{{$entrada->responsavel}}</td>
                                            <td>{{$entrada->data_entrada}}</td>
                                            <td>@if($entrada->motivo=='')Compra
                                                @else Retorno
                                                @endif</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;"><button type="submit" class="btn btn-icon" data-toggle="modal" data-target="#detail_item" onclick="detalhes_entrada('{{$entrada->id}}')"><span class="glyphicon glyphicon-eye-open"></span></button></div>
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

<div class="modal fade" id="detail_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Detalhes da entrada</div>
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
