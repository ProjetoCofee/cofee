@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a>
                            </li>
                            <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked"> 
                                    <li style = "padding-left: 10px " class="active"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span>  Clientes</a></li> 
                                    <li style = "padding-left: 10px "><a href="/cadastro/fornecedor-fisica"> <span class="glyphicon glyphicon-menu-right"></span> Fornecedores</a></li>
                                </ul>
                            </li>
                            <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Clientes</div>
                        <div class="panel-body">
                        @if($tipo == "cliente-fisica")
                            
                            <table>
                                <tr>
                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/cliente_fisica/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/cliente-fisica" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            @if($clientesF)
                                <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Telefone</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            
                                @foreach($clientesF as $cliente)

                                    <tbody>
                                        <tr>
                                            <td>{{$cliente->nome}}</td>
                                            <td>{{substr($cliente->cpf,0,3) . "." . substr($cliente->cpf,3,3) . "." . substr($cliente->cpf,6,3) . "-" . substr($cliente->cpf,9,3)}}</td>
                                            <td>{{$cliente->telefone}}</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                <form method="GET" action="mailto:{{$cliente->email}}"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-envelope"></span></button></form>
                                                
                                                <form method="GET" action="cliente/{{$cliente->id}}/delete"><button type="submit" class="btn btn-icon remove"><span class="glyphicon glyphicon-trash"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                                </TABLE>
                            @endif
                        @endif

                        @if($tipo == "cliente-juridica")
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="cliente/pessoa">
                                            <button type="submit" class="btn btn-primary">Novo</button>
                                        </form>
                                    </td>

                                    <td>
                                        <select name="tipo" class="form-control" onchange="location = this.value;" style="margin-bottom: 1em;">
                                            <option value="cliente-fisica">Pessoa Física</option>
                                            <option value="cliente-juridica" selected>Pessoa Jurídica</option>
                                        </select>
                                    </td>

                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/cliente_juridica/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/cliente-juridica" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <TABLE  class="table table-hover">
                            @if($clientesJ)
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Razão Social</th>
                                        <th>CNPJ</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                @foreach($clientesJ as $cliente)
                                    <tbody>
                                        <tr>
                                            <td>{{$cliente->nome_fantasia}}</td>
                                            <td>{{$cliente->razao_social}}</td>
                                            <td>{{substr($cliente->cnpj,0,2) . "." . substr($cliente->cnpj,2,3) . "." . substr($cliente->cnpj,5,3) . "/" . substr($cliente->cnpj,8,4)  . "-" . substr($cliente->cnpj,12,2)}}</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                <form method="GET" action="mailto:{{$cliente->email}}"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-envelope"></span></button></form>
                                                
                                                <form method="GET" action="cliente/{{$cliente->id}}/delete"><button type="submit" class="btn btn-icon remove"><span class="glyphicon glyphicon-trash"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @endif
                            </TABLE>
                        @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
