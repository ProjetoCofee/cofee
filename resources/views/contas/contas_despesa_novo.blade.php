@extends('layouts.app')

@section('content')

<script type="text/javascript">

    function atualiza_campos_repete(value){
        
        $('#repete').empty();

        if (value == '1') {

            $('#repete').html('<div class="form-group{{ $errors->has('qtd_parcelas') ? ' has-error' : '' }}"><label for="qtd_parcelas" class="col-md-4 control-label">Qtd. Parcelas</label><div class="col-md-6"><input id="qtd_parcelas" type="number" class="form-control" name="qtd_parcelas" value="{{ old('qtd_parcelas') }}" required>@if ($errors->has('qtd_parcelas'))<span class="help-block"><strong>{{ $errors->first('qtd_parcelas') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('intervalo') ? ' has-error' : '' }}"><label for="intervalo" class="col-md-4 control-label">Intervalo</label><div class="col-md-6"><select name="intervalo" class="form-control" required><option value=""></option><option value="7">7 dias</option><option value="15">15 dias</option><option value="30">30 dias</option><option value="60">60 dias</option><option value="90">90 dias</option></select>@if ($errors->has('intervalo'))<span class="help-block"><strong>{{ $errors->first('intervalo') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('data_vencimento') ? ' has-error' : '' }}"><label for="data_vencimento" class="col-md-4 control-label">Data vencimento</label><div class="col-md-6"><input id="data_vencimento" type="date" class="form-control" name="data_vencimento" value="{{ old('data_vencimento') }}" required>@if ($errors->has('data_vencimento'))<span class="help-block"><strong>{{ $errors->first('data_vencimento') }}</strong></span>@endif</div></div>');

        }else if (value == '0') {
            $('#repete').html('<div class="form-group{{ $errors->has('data_vencimento') ? ' has-error' : '' }}"><label for="data_vencimento" class="col-md-4 control-label">Data vencimento</label><div class="col-md-6"><input id="data_vencimento" type="date" class="form-control" name="data_vencimento" value="{{ old('data_vencimento') }}" required>@if ($errors->has('data_vencimento'))<span class="help-block"><strong>{{ $errors->first('data_vencimento') }}</strong></span>@endif</div></div>');
        }  
    }

</script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar despesa</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/contas/despesas/novo">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('fornecedor') ? ' has-error' : '' }}">
                            <label for="fornecedor" class="col-md-4 control-label">Fornecedor</label>

                            <div class="col-md-6">
                                <select name="fornecedor" class="form-control" required>
                                    <option value=""></option>

                                    @foreach($fornecedors as $fornecedor)
                                        <option value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('fornecedor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fornecedor') }}</strong>
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

                        <div class="form-group{{ $errors->has('categoria') ? ' has-error' : '' }}">
                            <label for="categoria" class="col-md-4 control-label">Categoria</label>

                            <div class="col-md-6">
                                <select name="categoria" class="form-control" required>
                                    <option value=""></option>

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
                            <label for="valor" class="col-md-4 control-label">Valor R$</label>

                            <div class="col-md-6">
                                <input id="valor" type="text" class="form-control" name="valor" value="{{ old('valor') }}" autocomplete="off" required>

                                @if ($errors->has('valor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('repete') ? ' has-error' : '' }}">
                            <label for="repete" class="col-md-4 control-label">Repete</label>

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
