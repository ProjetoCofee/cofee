@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Pessoa</div>
                <div class="panel-body">

                    <script>
                        function formatar(mascara, documento, tipo){
                            var i = documento.value.length;
                            var saida = mascara.substring(0,1);
                            var texto = mascara.substring(i)

                            if (texto.substring(0,1) != saida){
                                documento.value += texto.substring(0,1);
                            }
                            
                            if(documento.value.length >= 9 && tipo == 'cep'){
                                getCep();
                            } else if(documento.value.length < 9 && tipo == 'cep'){
                                form.remove();
                            }
                            
                        }
                    </script>

                    <script type="text/javascript">

                        var url = "http://localhost:8000/";

                        function getPageDataEnter(event) {
                            if(event.keyCode == 13){
                                getCep();
                            } 
                        }

                        function getCep() {

                            busca = ({ "cep": $("#cep").val().replace(/[^\d]+/g,'') }); 
                            
                            $.ajax({
                                dataType: 'json',
                                url: 'http://viacep.com.br/ws/'+busca.cep+'/json/'
                            }).done(function(data){

                                $('#resultadoCep').empty();
                                $('#preCep').empty();

                                $('#resultadoCep').append('<div id="form"><div class="form-group"><label for="uf" class="col-md-4 control-label" id="ufL">UF</label><div class="col-md-6"><input id="uf" type="text" class="form-control" name="uf" value="'+data.uf+'" readonly></div></div><div class="form-group"><label for="cidade" class="col-md-4 control-label" id="cidadeL">Cidade</label><div class="col-md-6"><input id="cidade" type="text" class="form-control" name="cidade" value="'+data.localidade+'" readonly></div></div><div class="form-group"><label for="bairro" class="col-md-4 control-label" id="bairroL">Bairro</label><div class="col-md-6"><input id="bairro" type="text" class="form-control" name="bairro" value="'+data.bairro+'" readonly></div></div><div class="form-group"><label for="logradouro" class="col-md-4 control-label" id="logradouroL">Logradouro</label><div class="col-md-6"><input id="logradouro" type="text" class="form-control" name="logradouro" value="'+data.logradouro+'" readonly></div></div><div class="form-group"><label for="numero" class="col-md-4 control-label" id="numeroL">Número</label><div class="col-md-6"><input id="numero" type="number" class="form-control" name="numero" required autocomplete = "false"></div></div></div>'
                                    );
                            });
                        }

                    </script>

                    <form class="form-horizontal" method="POST" action="/cadastro/pessoa/juridica/{{$pessoa_juridica->id}}/save">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div align="left">
                                <div style="padding:15px">
                                    <legend align="left">Informações Pessoais:</legend>
                                </div>

                                <div class="form-group{{ $errors->has('cnpj') ? ' has-error' : '' }}">
                                    <label for="cnpj" class="col-md-4 control-label">CNPJ</label>

                                    <div class="col-md-6">
                                        <input id="cnpj" type="text" class="form-control" name="cnpj" OnKeyPress="formatar('###.###.##-##', this, 'cnpj')" readonly="true" value="{{$pessoa_juridica->cnpj}}" required>

                                        @if ($errors->has('cnpj'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cnpj') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('nome_fantasia') ? ' has-error' : '' }}">
                                    <label for="nome_fantasia" class="col-md-4 control-label">Nome Fantasia</label>

                                    <div class="col-md-6">
                                        <input id="nome_fantasia" type="text" class="form-control" name="nome_fantasia" value="{{$pessoa_juridica->nome_fantasia}}" required autofocus>

                                        @if ($errors->has('nome_fantasia'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nome_fantasia') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('razao_social') ? ' has-error' : '' }}">
                                    <label for="razao_social" class="col-md-4 control-label">Razão Social</label>

                                    <div class="col-md-6">
                                        <input id="razao_social" type="text" class="form-control" name="razao_social" value="{{$pessoa_juridica->razao_social}}" required autofocus>

                                        @if ($errors->has('razao_social'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('razao_social') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('inscricao_estadual') ? ' has-error' : '' }}">
                                    <label for="inscricao_estadual" class="col-md-4 control-label">Inscrição Estadual</label>

                                    <div class="col-md-6">
                                        <input id="inscricao_estadual" type="text" class="form-control" name="inscricao_estadual" value="{{$pessoa_juridica->inscricao_estadual}}" required autofocus>

                                        @if ($errors->has('inscricao_estadual'))
                                        <span class="help-block">inscricao_estadual
                                            <strong>{{ $errors->first('inscricao_estadual') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                    <label for="telefone" class="col-md-4 control-label">Telefone</label>

                                    <div class="col-md-6">
                                        <input id="telefone" type="text" class="form-control" OnKeyPress="formatar('##-#####-####', this, telefone)" name="telefone" value="{{$pessoa_juridica->telefone}}" required autofocus>

                                        @if ($errors->has('telefone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('telefone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('telefone_sec') ? ' has-error' : '' }}">
                                    <label for="telefone_sec" class="col-md-4 control-label">Telefone Secundário</label>

                                    <div class="col-md-6">
                                        <input id="telefone_sec" type="text" class="form-control" OnKeyPress="formatar('##-#####-####', this, 'telefone_sec')" name="telefone_sec" value="{{$pessoa_juridica->telefone_sec}}" required autofocus>

                                        @if ($errors->has('telefone_sec'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('telefone_sec') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">Email</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text" class="form-control" name="email" value="{{$pessoa_juridica->email}}" required autofocus>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>



                                <div style="padding:15px">
                                    <legend align="left">Dados de Endereço:</legend>
                                </div>

                                <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                                    <label for="cep" class="col-md-4 control-label">CEP</label>

                                    <div class="col-md-6">
                                        <input id="cep" onpaste="return false;" maxlength="9" type="text" class="form-control" name="cep" onkeyup="formatar('#####-###', this, 'cep')" autocomplete="false" value="{{$pessoa_juridica->cep}}" required>

                                        @if ($errors->has('cep'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cep') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div id="resultadoCep">

                                </div>

                                <div id="preCep">

                                    <div class="form-group">
                                        <label for="uf" class="col-md-4 control-label" id="ufL">UF</label>
                                        <div class="col-md-6">
                                            <input id="uf" type="text" class="form-control" name="uf" value="{{$pessoa_juridica->uf}}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cidade" class="col-md-4 control-label" id="cidadeL">Cidade</label>
                                        <div class="col-md-6">
                                            <input id="cidade" type="text" class="form-control" name="cidade" value="{{$pessoa_juridica->cidade}}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="bairro" class="col-md-4 control-label" id="bairroL">Bairro</label>
                                        <div class="col-md-6">
                                            <input id="bairro" type="text" class="form-control" name="bairro" value="{{$pessoa_juridica->bairro}}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="logradouro" class="col-md-4 control-label" id="logradouroL">Logradouro</label>
                                        <div class="col-md-6">
                                            <input id="logradouro" type="text" class="form-control" name="logradouro" value="{{$pessoa_juridica->logradouro}}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="numero" class="col-md-4 control-label" id="numeroL">Número</label>
                                        <div class="col-md-6">
                                            <input id="numero" type="number" class="form-control" name="numero" value="{{$pessoa_juridica->numero}}" required autocomplete = "false">
                                        </div>
                                    </div>
                                </div>

                                @if($pessoa_juridica->tipo == "c")
                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>

                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f"> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c" checked> Cliente 
                                    </div>
                                </div>
                                @elseif($pessoa_juridica->tipo == "f")
                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>

                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f" checked> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c"> Cliente 
                                    </div>
                                </div>
                                @else
                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>

                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f" checked> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c" checked> Cliente 
                                    </div>
                                </div>
                                @endif

                                <div class="form-group">
                                    <div align="center">
                                        <button type="submit" class="btn btn-primary">
                                            Registrar
                                        </button>
                                        <button type="reset" name="cancel" class="btn btn-default" onclick="history.go(-1)">    
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection