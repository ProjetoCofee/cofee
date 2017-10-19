@extends('layouts.app')

@section('content')

<script type="text/javascript">

    function valida_ean(){

        var numero = document.getElementById('codigo_barras');

        var codigo = numero.value;
        var mascara = '#############';

        var i = numero.value.length;
        var saida = mascara.substring(0,1);
        var texto = mascara.substring(i)

        if (texto.substring(0,1) != saida){
            numero.value += texto.substring(0,1);
        }

        factor = 3;
        sum = 0;
        numlen = numero.value.length;
        if (numlen == 13){
            for(index = numero.value.length; index > 0; --index){
                if (index != 13){
                sum = sum + numero.value.substring (index-1, index) * factor;
                factor = 4 - factor;
                }
            }
            cc = ((1000 - sum) % 10);
            ca = numero.value.substring(12);
            if(cc == ca){
                $('#alerta').empty();
                document.getElementById("btn_salvar").disabled = false; 
            }
            else{
                $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">Digite um código EAN válido!</div>');
                document.getElementById("btn_salvar").disabled = true;
            }
        }
        if(numlen == 14){
            for(index = numero.value.length; index > 0; --index){
                if (index != 14){
                sum = sum + numero.value.substring (index-1, index) * factor;
                factor = 4 - factor;
                }
            }
            cc = ((1000 - sum) % 10);
            ca = numero.value.substring(13);
            if(cc == ca){
                $('#alerta').empty();
                document.getElementById("btn_salvar").disabled = false;
            }
            else{
                $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">Digite um código EAN válido!</div>');
                document.getElementById("btn_salvar").disabled = true;
            }
        }
        if(numlen == 8){
            for(index = numero.value.length; index > 0; --index){
                if (index != 8){
                sum = sum + numero.value.substring (index-1, index) * factor;
                factor = 4 - factor;
                }
            }
            cc = ((1000 - sum) % 10);
            ca = numero.value.substring(7);
            if(cc == ca){
                $('#alerta').empty();
                document.getElementById("btn_salvar").disabled = false;
            }
            else{
                $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">Digite um código EAN válido!</div>');     
                document.getElementById("btn_salvar").disabled = true;  
            }
        }
        if(numlen == 12){
            for(index = numero.value.length; index > 0; --index){
                if (index != 12){
                sum = sum + numero.value.substring (index-1, index) * factor;
                factor = 4 - factor;
                }
            }
            cc = ((1000 - sum) % 10);
            ca = numero.value.substring(11);
            if(cc == ca){
                $('#alerta').empty();
                document.getElementById("btn_salvar").disabled = false;
            }
            else{
                $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">Digite um código EAN válido!</div>');
                document.getElementById("btn_salvar").disabled = true;
            }
        }
        if (((((numlen != 8) && (numlen != 12)) && (numlen != 13)) && (numlen != 14))){
            $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">Digite um código EAN válido!</div>');
            document.getElementById("btn_salvar").disabled = true;
        }
    }
</script>

<div id="alerta"></div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar produto</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/cadastro/produto/cadastrar">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('departamento') ? ' has-error' : '' }}">
                            <label for="departamento" class="col-md-4 control-label">Departamento</label>

                            <div class="col-md-6">
                                <select name="departamento" class="form-control" required>
                                    <option value=""></option>
                                    <!--<option value="../departamento/cadastrar">Cadastrar departamento</option>
                                    <option value="">--</option>-->

                                    @foreach($departamentos as $departamento)
                                        <option value="{{$departamento->id}}">{{$departamento->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('departamento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departamento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('marca') ? ' has-error' : '' }}">
                            <label for="marca" class="col-md-4 control-label">Marca</label>

                            <div class="col-md-6">
                                <select name="marca" class="form-control" required>
                                    <option value=""></option>
                                    <!--<option value="../marca/cadastrar">Cadastrar marca</option>
                                    <option value="">--</option>-->

                                    @foreach($marcas as $marca)
                                        <option value="{{$marca->id}}">{{$marca->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('marca'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('marca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ old('descricao') }}" required>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('codigo_barras') ? ' has-error' : '' }}">
                            <label for="codigo_barras" class="col-md-4 control-label">Código de barras</label>

                            <div class="col-md-6">
                                <input id="codigo_barras" type="text" class="form-control" name="codigo_barras" value="{{ old('codigo_barras') }}" maxlength="13" onkeyup="valida_ean()" required>

                                @if ($errors->has('codigo_barras'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('codigo_barras') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('unidade_medida') ? ' has-error' : '' }}">
                            <label for="unidade_medida" class="col-md-4 control-label">Unidade de medida</label>

                            <div class="col-md-6">
                                <select name="unidade_medida" class="form-control" required>
                                    <option value=""></option>
                                    @foreach($unidade_medidas as $unidade_medida)
                                        <option value="{{$unidade_medida->nome}}">{{$unidade_medida->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('unidade_medida'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('unidade_medida') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('posicao') ? ' has-error' : '' }}">
                            <label for="posicao" class="col-md-4 control-label">Posição</label>

                            <div class="col-md-6">
                                <input id="posicao" type="text" class="form-control" name="posicao" value="{{ old('posicao') }}" required>

                                @if ($errors->has('posicao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('posicao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>    
                        <div class="form-group{{ $errors->has('minimo') ? ' has-error' : '' }}">
                            <label for="minimo" class="col-md-4 control-label">Quantidade mínima</label>

                            <div class="col-md-6">
                                <input id="minimo" type="number" class="form-control" name="minimo" value="{{ old('minimo') }}" required>

                                @if ($errors->has('minimo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('minimo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('observacao') ? ' has-error' : '' }}">
                            <label for="observacao" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <textarea id="observacao" rows="3" class="form-control" name="observacao" value="{{ old('observacao') }}"></textarea>

                                @if ($errors->has('observacao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('observacao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group">
                            <div align="center">
                                <button id="btn_salvar" type="submit" class="btn btn-primary">
                                    Salvar
                                </button>
                                <button type="reset" name="cancel" class="btn btn-default" onclick="history.go(-1)">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
