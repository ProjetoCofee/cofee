@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a></li>
                            <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a>
                                <li style = "padding-left: 10px "><a href="/cadastro/cliente-fisica"> <span class="glyphicon glyphicon-menu-right"></span>  Clientes</a></li> 
                                <li style = "padding-left: 10px "  class="active"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span> Fornecedores</a></li>
                            </li>
                            <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Fornecedores</div>
                        <div class="panel-body">
                        @if($tipo == "fornecedor-fisica")
                            
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="fornecedor/pessoa">
                                            <button type="submit" class="btn btn-primary">Novo</button>
                                        </form>
                                    </td>

                                    <td>
                                        <select name="tipo" class="form-control" onchange="location = this.value;" style="margin-bottom: 1em;">
                                            <option value="fornecedor-fisica" selected>Pessoa Física</option>
                                            <option value="fornecedor-juridica">Pessoa Jurídica</option>
                                        </select>
                                    </td>

                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/fornecedor_fisica/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/fornecedor-fisica" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            @if($fornecedorsF)
                                <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Telefone</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            
                                @foreach($fornecedorsF as $fornecedor)

                                    <tbody>
                                        <tr>
                                            <td>{{$fornecedor->nome}}</td>
                                            <td>{{substr($fornecedor->cpf,0,3) . "." . substr($fornecedor->cpf,3,3) . "." . substr($fornecedor->cpf,6,3) . "-" . substr($fornecedor->cpf,9,3)}}</td>
                                            <td>{{$fornecedor->telefone}}</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                <form method="GET" action="mailto:{{$fornecedor->email}}"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-envelope"></span></button></form>
                                                
                                                <form method="GET" action="fornecedor/{{$fornecedor->id}}/delete"><button type="submit" class="btn btn-icon remove"><span class="glyphicon glyphicon-trash"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                                </TABLE>
                            @endif
                        @endif
                        
                        @if($tipo == "fornecedor-juridica")
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="fornecedor/pessoa">
                                            <button type="submit" class="btn btn-primary">Novo</button>
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/forncedor_juridica/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/fornecedor-juridica" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <TABLE  class="table table-hover">
                            @if($fornecedorsJ)
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Razão Social</th>
                                        <th>CNPJ</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                @foreach($fornecedorsJ as $fornecedor)
                                    <tbody>
                                        <tr>
                                            <td>{{$fornecedor->nome_fantasia}}</td>
                                            <td>{{$fornecedor->razao_social}}</td>
                                            <td>{{substr($fornecedor->cnpj,0,2) . "." . substr($fornecedor->cnpj,2,3) . "." . substr($fornecedor->cnpj,5,3) . "/" . substr($fornecedor->cnpj,8,4)  . "-" . substr($fornecedor->cnpj,12,2)}}</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                <form method="GET" action="mailto:{{$fornecedor->email}}"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-envelope"></span></button></form>
                                                
                                                <form method="GET" action="fornecedor/{{$fornecedor->id}}/delete"><button type="submit" class="btn btn-icon remove"><span class="glyphicon glyphicon-trash"></span></button></form>
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
