@extends('layouts.app')

@section('content')

<script type="text/javascript">

    function modal_retirada(id){
        $.ajax({
            dataType: 'json',
            url: url+'api/busca_retirada_id.php',
            data: {busca:id}
        }).done(function(data){
            var id = data[0].id;
            var codigo_barras = data[0].codigo_barras;
            var descricao = data[0].descricao;
            var qtd_solicitada = data[0].qtd_solicitada;
            var qtd_atendida = data[0].qtd_atendida;
            $('#modal_retirada').html('<form class="form-horizontal"><div class="form-group"><label for="codigo_barras" class="col-md-4 control-label">Código</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="codigo_barras" type="text" class="form-control" name="codigo_barras" value="'+codigo_barras+'" readonly></div><label for="descricao" class="col-md-4 control-label">Descrição</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="descricao" type="text" class="form-control" name="descricao" value="'+descricao+'" readonly></div><label for="qtd_solicitada" class="col-md-4 control-label">Solicitado</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="qtd_solicitada" type="text" class="form-control" name="qtd_solicitada" value="'+qtd_solicitada+'" readonly></div><label for="qtd_atendida" class="col-md-4 control-label">Atender</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="qtd_atendida" type="number" class="form-control" name="qtd_atendida" autocomplete="off" onkeyup="calcula_saldo()" required></div><div align="center"><button data-toggle="modal" data-target="#create_modal_compra" id="btn_retirar" type="button" class="btn crud-submit btn-primary" onclick="aprova_retirada('+id+')" data-dismiss="modal" aria-label="Close">Retirar</button><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></div></div></form>');    
        });
    }

    function calcula_saldo(){
        var qtd_solicitada =  parseInt(document.getElementById('qtd_solicitada').value);
        var qtd_atendida =  parseInt(document.getElementById('qtd_atendida').value);
        if(qtd_atendida>qtd_solicitada || qtd_atendida<=0){
            document.getElementById("btn_retirar").disabled = true; 
        }else{
            document.getElementById("btn_retirar").disabled = false;
        }
    }

    function aprova_retirada(id){
        var id_solicitacao = "<?php print $id_solicitacao ?>";
        var id_retirada = id;
        var qtd_atendida = document.getElementById('qtd_atendida').value;
        var id_usuario_aprova = "<?php print Auth::user()->id ?>";
        var codigo_produto = document.getElementById('codigo_barras').value;
        if(id_solicitacao != '' && id_retirada != '' && qtd_atendida != '' && id_usuario_aprova != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/aprova_retirada_item.php',
                data:{  id_solicitacao:id_solicitacao,
                        id_retirada:id_retirada,
                        id_usuario_aprova:id_usuario_aprova,
                        codigo_produto:codigo_produto,
                        qtd_atendida:qtd_atendida
                    }
            }).done(function(data){
                var id = data[0].id;
                var descricao = data[0].descricao;
                var saldo = data[0].saldo;
                var minimo = data[0].minimo;

                var saldo = parseInt(saldo);
                var minimo = parseInt(minimo);
                if(saldo<=minimo){
                    $('#modal_compra').html('<div align="center"><p>Com esta retirada o saldo de '+descricao+'<br>é '+saldo+' enquanto o mínimo deve ser '+minimo+'.<br><br>Gostaria de adicionar este produto à lista para compra?</p></div><br><br><div align="center"><button id="btn_retirar" type="button" class="btn crud-submit btn-primary" onclick="inserir_compra('+id+')" data-dismiss="modal" aria-label="Close">Adicionar</button><button type="button" class="btn crud-submit btn-default" onclick="ignorar_compra()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Ignorar</span></button></div>');
                }else{
                    $('#create_modal_compra').empty();
                    $('#create_modal_compra').hide();
                    location.reload();
                }
            });
        }
    }

    function inserir_compra(id){
        var id_produto = id;
        var id_usuario_solicitante = "<?php print Auth::user()->id ?>";
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/create_item_compra.php',
            data:{id_produto:id_produto, id_usuario_solicitante:id_usuario_solicitante}
        }).done(function(data){
            location.reload();
        });
    }

    function ignorar_compra(){
        location.reload();
    }

    function recusa_retirada(id){
        var id_solicitacao = "<?php print $id_solicitacao ?>";
        var id_retirada = id;
        var id_usuario_aprova = "<?php print Auth::user()->id ?>";
        if(id_solicitacao != '' && id_retirada != '' && id_usuario_aprova != ''){
           $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/recusa_retirada_item.php',
                data:{  id_solicitacao:id_solicitacao,
                        id_retirada:id_retirada,
                        id_usuario_aprova:id_usuario_aprova
                    }
            }).done(function(){
                location.reload();
            });
        }
    }

    function salvar_retirada(){
        var id_solicitacao = "<?php print $id_solicitacao ?>";
        if(id_solicitacao != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/salvar_retirada.php',
                data:{id_solicitacao:id_solicitacao}
            }).done(function(){
                window.location.replace('/estoque/retirada');
            });
        }
    }

    function cancelar_retirada(){
        var id_solicitacao = "<?php print $id_solicitacao ?>";
        if(id_solicitacao != ''){
           $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/cancelar_retirada.php',
                data:{ id_solicitacao:id_solicitacao}
            }).done(function(){
                window.location.replace('/estoque/retirada');
            });
        }
    }

</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Estoque</div>
                        @if($status == 'p')
                        <ul class="nav nav-pills nav-stacked">
                            <li><a>Estoque<span class="sr-only">(current)</span></a></li>
                            <li><a>Entrada<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a>Retirada<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="subactive"><a> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Solicitações retirada</a></li> 
                                    <li style = "padding-left: 5px;"><a> <span class="glyphicon glyphicon-menu-right"></span> Solicitações compra</a></li>
                                    <!-- <li style = "padding-left: 5px;"><a> <span class="glyphicon glyphicon-menu-right"></span> Solicitar retirada</a></li> -->
                                </ul>
                            </li>
                        </ul>
                        @else
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/estoque/show">Estoque<span class="sr-only">(current)</span></a></li>
                            <li><a href="/estoque/historico_entrada">Entrada<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a>Retirada<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="subactive"><a href="/estoque/retirada"> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Solicitações retirada</a></li> 
                                    <li style = "padding-left: 5px;"><a href="/estoque/compra"> <span class="glyphicon glyphicon-menu-right"></span> Solicitações compra</a></li>
                                    <!-- <li style = "padding-left: 5px;"><a href="/estoque/solicita_retirada"> <span class="glyphicon glyphicon-menu-right"></span> Solicitar retirada</a></li> -->
                                </ul>
                            </li>
                        </ul>
                        @endif
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Solicitação de retirada</div>
                        <div class="panel-body">

                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Nº solicitação</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$id_solicitacao}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Solicitante</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$solicitante}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Data solicitação</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$data_solicitacao}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Aprovador</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$aprovador}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Data aprovação</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$data_aprovacao}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código barras</th>
                                        <th>Descrição</th>
                                        <th>Saldo</th>
                                        <th>Un. Medida</th>
                                        <th>Qtd. Solicitada</th>
                                        <th>Qtd. Aprovada</th>
                                        <th>Aprovado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($retiradas)
                                    @foreach($retiradas as $retirada)
                                    <tbody>
                                        <tr>
                                            <td>{{$retirada->codigo_barras}}</td>
                                            <td>{{$retirada->descricao}}</td>
                                            <td>{{$retirada->saldo}}</td>
                                            <td>{{$retirada->unidade_medida}}</td>
                                            <td>{{$retirada->qtd_solicitada}}</td>
                                            <td>{{$retirada->qtd_atendida}}</td>
                                            <td>@if($retirada->aprovado)Sim
                                                @else Não
                                                @endif</td>
                                            @if($retirada->status == 'p')
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                <button type="submit" class="btn btn-icon add" data-toggle="modal" data-target="#create-item" onclick="modal_retirada('{{$retirada->id}}')"><span class="glyphicon glyphicon-thumbs-up"></span></button>
                                                <button type="submit" class="btn btn-icon remove" onclick="recusa_retirada('{{$retirada->id}}')"><span class="glyphicon glyphicon-thumbs-down"></span></button>
                                                </div>
                                            </td>
                                            @else
                                            <td>
                                            </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                    @endforeach
                                @endif
                            </TABLE>

                            <div align="center">
                                @if($status == 'p')
                                <button class="btn btn-primary" type="button" onclick="salvar_retirada()">
                                    Salvar
                                </button>
                                <button class="btn btn-primary" type="button" onclick="cancelar_retirada()">
                                    Cancelar
                                </button>
                                @else
                                <button class="btn btn-primary" type="button" onclick="history.go(-1)">
                                    Voltar
                                </button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Create Item Modal -->
<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div class="panel panel-default">
            <div class="panel-heading">Aprovar retirada do item</div>
            <div class="panel-body">

            <div id="modal_retirada" class="modal-body" style="color: #1E3973">
            <!-- conteudo js -->
            </div>

            </div>
        </div>
        
        </div>
    </div>
</div>

<div class="modal fade" id="create_modal_compra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div class="panel panel-default">
            <div class="panel-heading">Produto acabando</div>
            <div class="panel-body">

            <div id="modal_compra" class="modal-body" style="color: #1E3973">
            <!-- conteudo js -->
            </div>

            </div>
        </div>
        
        </div>
    </div>
</div>

@endsection
