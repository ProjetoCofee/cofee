@extends('layouts.app')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('cliente').focus();
    };

    function atualiza_campos_repete(value){
        
        $('#repete').empty();

        if (value == '1') {

            $('#repete').html('<div class="form-group{{ $errors->has('qtd_parcelas') ? ' has-error' : '' }}"><label for="qtd_parcelas" class="col-md-4 control-label required">Qtd. Parcelas</label><div class="col-md-6"><input id="qtd_parcelas" type="number" class="form-control" name="qtd_parcelas" style="text-align: right;" placeholder="Ex: 12" value="{{ old('qtd_parcelas') }}" required>@if ($errors->has('qtd_parcelas'))<span class="help-block"><strong>{{ $errors->first('qtd_parcelas') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('intervalo') ? ' has-error' : '' }}"><label for="intervalo" class="col-md-4 control-label required">Intervalo (dias)</label><div class="col-md-6"><input id="intervalo" type="number" min="1" max="1461   " class="form-control" name="intervalo" style="text-align: right;" placeholder="Ex: 30" value="{{ old('intervalo') }}" required>@if ($errors->has('intervalo'))<span class="help-block"><strong>{{ $errors->first('intervalo') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('data_vencimento') ? ' has-error' : '' }}"><label for="data_vencimento" class="col-md-4 control-label required">Data vencimento</label><div class="col-md-6"><input id="data_vencimento" type="date" class="form-control" name="data_vencimento" value="{{ old('data_vencimento') }}" required>@if ($errors->has('data_vencimento'))<span class="help-block"><strong>{{ $errors->first('data_vencimento') }}</strong></span>@endif</div></div>');

        }else if (value == '0') {
            $('#repete').html('<div class="form-group{{ $errors->has('data_vencimento') ? ' has-error' : '' }}"><label for="data_vencimento" class="col-md-4 control-label required">Data vencimento</label><div class="col-md-6"><input id="data_vencimento" type="date" class="form-control" name="data_vencimento" value="{{ old('data_vencimento') }}" required>@if ($errors->has('data_vencimento'))<span class="help-block"><strong>{{ $errors->first('data_vencimento') }}</strong></span>@endif</div></div>');
        }  
    }

</script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar receita</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/contas/receitas/novo">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('cliente') ? ' has-error' : '' }}">
                            <label for="cliente" class="col-md-4 control-label required">Cliente</label>

                            <div class="col-md-6">
                                <select id="cliente" name="cliente" class="form-control" required>
                                    <option value="">Escolha um cliente</option>

                                    @foreach($clientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('cliente'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cliente') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label required">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ old('descricao') }}" placeholder="Ex: Venda para cliente" required>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('categoria') ? ' has-error' : '' }}">
                            <label for="categoria" class="col-md-4 control-label required">Categoria</label>

                            <div class="col-md-6">
                                <select name="categoria" class="form-control" required>
                                    <option value="">Escolha uma categoria</option>

                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('categoria'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categoria') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('valor') ? ' has-error' : '' }}">
                            <label for="valor" class="col-md-4 control-label required">Valor R$</label>

                            <div class="col-md-6">
                                <input id="valor" min="0,01" step="any" class="form-control" name="valor" value="{{ old('valor') }}" style="text-align: right;" placeholder="Ex: 0,00" autocomplete="off" required>

                                @if ($errors->has('valor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('repete') ? ' has-error' : '' }}">
                            <label for="repete" class="col-md-4 control-label required">Repete</label>

                            <div class="col-md-6">
                                <input type="radio" name="repete" value="1" onchange="atualiza_campos_repete(this.value)"> Sim<br>
                                <input type="radio" name="repete" value="0" onchange="atualiza_campos_repete(this.value)"> Não<br>
                            </div>
                        </div>

                        <div id="repete">
                            <!-- conteudo js -->
                        </div>

                        <div class="form-group">
                            <div align="center">
                                <button type="submit" class="btn btn-primary">
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
