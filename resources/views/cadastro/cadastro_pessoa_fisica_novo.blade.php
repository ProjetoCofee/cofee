@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Pessoa</div>
                <div class="panel-body">

                    <script type="text/javascript">
                        function formatar(mascara, documento, tipo){

                            if(documento.value.length > 11  &&  tipo == 'telefone'){
                                mascara = '##-#####-####';
                            }

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

                        var url = "http://localhost:8000/";

                        function getPageDataEnter(event) {
                            if(event.keyCode == 13){
                                getCep();
                            } 
                        }

                        function getCep() {

                            busca = ({ "cep": $("#cep").val().replace(/[^\d]+/g,'') }); 
                            console.log(busca.cep);
                            $('#tabela_produtos').empty();
                            $.ajax({
                                dataType: 'json',
                                url: 'http://viacep.com.br/ws/'+busca.cep+'/json/'
                            }).done(function(data){
                                console.log(data);
                                $('#resultadoCep').empty();
                                $('#resultadoCep').append('<div id="form"><div class="form-group"><label for="uf" class="col-md-4 control-label" id="ufL">UF</label><div class="col-md-6"><input id="uf" type="text" class="form-control" name="uf" value="'+data.uf+'" readonly></div></div><div class="form-group"><label for="cidade" class="col-md-4 control-label" id="cidadeL">Cidade</label><div class="col-md-6"><input id="cidade" type="text" class="form-control" name="cidade" value="'+data.localidade+'" readonly></div></div><div class="form-group"><label for="bairro" class="col-md-4 control-label" id="bairroL">Bairro</label><div class="col-md-6"><input id="bairro" type="text" class="form-control" name="bairro" value="'+data.bairro+'" readonly></div></div><div class="form-group"><label for="logradouro" class="col-md-4 control-label" id="logradouroL">Logradouro</label><div class="col-md-6"><input id="logradouro" type="text" class="form-control" name="logradouro" value="'+data.logradouro+'" readonly></div></div><div class="form-group"><label for="numero" class="col-md-4 control-label" id="numeroL">Número</label><div class="col-md-6"><input id="numero" type="number" class="form-control" name="numero" required autocomplete = "false"></div></div></div>'
                                    );
                            });
                        }

                    </script>

                    <form class="form-horizontal" method="POST" action="/cadastro/pessoa/fisica/create">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div align="left">
                                <div style="padding:15px">
                                    <legend align="left">Informações Pessoais:</legend>
                                </div>

                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label for="nome" class="col-md-4 control-label">Nome</label>

                                    <div class="col-md-6">
                                        <input id="nome" type="text" class="form-control" name="nome" required autofocus>

                                        @if ($errors->has('nome'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                    <label for="cpf" class="col-md-4 control-label">CPF</label>

                                    <div class="col-md-6">
                                        <input id="cpf" type="text" class="form-control" name="cpf" OnKeyPress="formatar('###.###.###-##', this, 'cpf')" value="{{$cpf}}" readonly="true" required>

                                        @if ($errors->has('cpf'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cpf') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
                                    <label for="rg" class="col-md-4 control-label">RG</label>

                                    <div class="col-md-6">
                                        <input id="rg" type="text" maxlength="13" class="form-control" name="rg" OnKeyPress="formatar('##.###.###-##', this, 'rg')" required autofocus>

                                        @if ($errors->has('rg'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rg') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
                                    <label for="sexo" class="col-md-4 control-label">Sexo</label>

                                    <div class="col-md-6">
                                        <input type="radio" name="sexo" value="m"> Masculino<br>
                                        <input type="radio" name="sexo" value="f"> Feminino<br>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('data_nascim') ? ' has-error' : '' }}">
                                    <label for="data_nascim" class="col-md-4 control-label">Data de Nascimento</label>

                                    <div class="col-md-6">
                                        <input id="data_nascim" type="date" class="form-control" OnKeyPress="formatar('##/##/####', this, 'data_nascim')" name="data_nascim" required autofocus>

                                        @if ($errors->has('data_nascim'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('data_nascim') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                    <label for="telefone" class="col-md-4 control-label">Telefone</label>

                                    <div class="col-md-6">
                                        <input id="telefone" type="text" maxlength="16" class="form-control" onkeyup="formatar('##-####-####', this, 'telefone')" name="telefone" autofocus>

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
                                        <input id="telefone_sec" type="text" maxlength="16" class="form-control" onkeyup="formatar('##-####-####', this, 'telefone')" name="telefone_sec" autofocus>

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
                                        <input id="email" type="text" class="form-control" name="email" required autofocus>

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
                                        <input id="cep" onpaste="return false;" maxlength="9" type="text" class="form-control" name="cep" onkeyup="formatar('#####-###', this, 'cep')" autocomplete="false" required>

                                        @if ($errors->has('cep'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cep') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>  

                                <div id="resultadoCep">

                                </div> 

                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>

                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f"> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c"> Cliente 
                                    </div>
                                </div>
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