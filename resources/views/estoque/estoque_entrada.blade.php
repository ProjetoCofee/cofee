@extends('layouts.app')

@section('content')

<script type="text/javascript">

    function atualiza_campos(value){
        
        $('#tipo_entrada').empty();

        if (value == "compra") {

            $('#tipo_entrada').html('<div class="form-group{{ $errors->has('data_entrada') ? ' has-error' : '' }}"><br><br><label for="data_entrada" class="col-md-4 control-label">Data entrada</label><div class="col-md-6" style="padding-right: 15%;"><input id="data_entrada" type="date" class="form-control" name="data_entrada" value="{{ old('data_entrada') }}" autocomplete="off" autofocus="autofocus" required="true">@if ($errors->has('data_entrada'))<span class="help-block"><strong>{{ $errors->first('data_entrada') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('serie_nf') ? ' has-error' : '' }}"><label for="serie_nf" class="col-md-4 control-label">Série nota fiscal</label><div class="col-md-6" style="padding-right: 15%;"><input id="serie_nf" type="text" class="form-control" name="serie_nf" placeholder="Série nota fiscal" maxlength="9" value="{{ old('serie_nf') }}" autocomplete="off" autofocus="autofocus" required="true">@if ($errors->has('serie_nf'))<span class="help-block"><strong>{{ $errors->first('serie_nf') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('num_nota_fiscal') ? ' has-error' : '' }}"><label for="num_nota_fiscal" class="col-md-4 control-label">Nº nota fiscal</label><div class="col-md-6" style="padding-right: 15%;"><input id="num_nota_fiscal" type="text" class="form-control" name="num_nota_fiscal" placeholder="Nº nota fiscal" maxlength="9" value="{{ old('num_nota_fiscal') }}" autocomplete="off" autofocus="autofocus" required="true">@if ($errors->has('num_nota_fiscal'))<span class="help-block"><strong>{{ $errors->first('num_nota_fiscal') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('fornecedor') ? ' has-error' : '' }}"><label for="fornecedor" class="col-md-4 control-label">Fornecedor</label><div class="col-md-6" style="padding-right: 15%;"><select name="fornecedor" class="form-control" required><option value=""></option>@foreach($fornecedors as $fornecedor)<option value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>@endforeach</select>@if ($errors->has('fornecedor'))<span class="help-block"><strong>{{ $errors->first('fornecedor') }}</strong></span>@endif</div></div>');

        }else if (value == "retorno") {
            $('#tipo_entrada').html('<div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }}"><br><br><label for="motivo" class="col-md-4 control-label">Motivo</label><div class="col-md-6" style="padding-right: 15%;"><input id="motivo" type="text" class="form-control" name="motivo" placeholder="Motivo do retorno" value="{{ old('motivo') }}" autocomplete="off" autofocus="autofocus" required="true">@if ($errors->has('motivo'))<span class="help-block"><strong>{{ $errors->first('motivo') }}</strong></span>@endif</div>');
        }  
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
                        <li class="active"><a>Entrada<span class="sr-only">(current)</span></a></li>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/estoque/historico_entrada"> <span style="font-size: 16px;" class="glyphicon glyphicon-menu-right"></span>  Histórico entradas</a></li>
                                <li class="subactive"><a> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Realizar entrada</a></li> 
                            </ul>
                        <li><a href="/estoque/retirada">Retirada<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Entrada de produtos</div>
                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="produto">
                                {{ csrf_field() }}
                               
                                <div class="form-group{{ $errors->has('tipo_entrada') ? ' has-error' : '' }}">
                                    <label for="tipo_entrada" class="col-md-4 control-label">Tipo de entrada</label>

                                    <div class="col-md-6">
                                        <input type="radio" name="tipo_entrada" value="compra" onchange="atualiza_campos(this.value)"> Compra de novos produtos<br>
                                        <input type="radio" name="tipo_entrada" value="retorno" onchange="atualiza_campos(this.value)"> Retorno de produtos<br>
                                    </div>
                                </div>
                                
                                <div id="tipo_entrada">
                                    <!-- conteudo js -->
                                </div>
                                <br>
                                <br>

                                <div class="form-group">
                                    <div align="center">
                                        <button type="submit" class="btn btn-primary">
                                            Próximo
                                        </button>
                                    </div>
                                </div>
                            </form>                           
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
