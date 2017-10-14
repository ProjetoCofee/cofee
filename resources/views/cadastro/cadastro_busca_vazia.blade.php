@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            @if($tipo == "produto")
            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a>
                            <ul class="nav nav-pills nav-stacked"> 
                                <li style = "padding-left: 10px" class="active"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span>  Departamento</a></li> 
                                <li style = "padding-left: 10px "><a href="/cadastro/marca"> <span class="glyphicon glyphicon-menu-right"></span> Marca</a></li> 
                            </ul>
                        </li>
                        <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                        <li><a href="/cadastro/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de produtos</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <tr>
                                        <td style="padding-bottom: 1em;">
                                            <form method="post" action="/cadastro/produto/busca" class="form-inline" role="search">
                                                <div class="form-group">
                                                    <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                                </div>
                                                <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                                {{ csrf_field() }}
                                            </form>
                                        </td>
                                        <td style="padding-bottom: 1em;">
                                            <form method="get" action="/cadastro/produto" class="form-inline">
                                                <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                                {{ csrf_field() }}
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($tipo == "departamento")
            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a>
                            <ul class="nav nav-pills nav-stacked"> 
                                <li style = "padding-left: 10px" class="active"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span>  Departamento</a></li> 
                                <li style = "padding-left: 10px "><a href="/cadastro/marca"> <span class="glyphicon glyphicon-menu-right"></span> Marca</a></li> 
                            </ul>
                        </li>
                        <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                        <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Departamento</div>
                        <div class="panel-body">

                            <table>
                                <tr>
                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/departamento/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/departamento" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>

                    </div>
                </div>
            </div>
            @endif

            @if($tipo == "marca")
            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked"> 
                                    <li style = "padding-left: 10px"><a href="/cadastro/departamento"> <span class="glyphicon glyphicon-menu-right"></span>  Departamento</a></li> 
                                    <li style = "padding-left: 10px" class="active"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span> Marca</a></li> 
                                </ul>
                            </li>
                            <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                            <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>

            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Marca</div>
                        <div class="panel-body">

                            <table>
                                <tr>
                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/marca/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/marca" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>

                    </div>
                </div>
            </div>
            @endif

            @if($tipo == "fisica")

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Pessoas<span class="sr-only">(current)</span></a>
                            <ul class="nav nav-pills nav-stacked"> 
                                <li style = "padding-left: 10px "><a href="/cadastro/cliente-fisica"> <span class="glyphicon glyphicon-menu-right"></span>  Clientes</a></li> 
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
                        <div class="panel-heading">Cadastro de Pessoas</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <tr>
                                        <td style="padding-bottom: 1em; padding-left: 1em;">
                                            <form method="post" action="/cadastro/pessoa_fisica/busca" class="form-inline" role="search">
                                                <div class="form-group">
                                                    <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                                </div>
                                                <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                                {{ csrf_field() }}
                                            </form>
                                        </td>

                                        <td style="padding-bottom: 1em;">
                                            <form method="get" action="/cadastro/fisica" class="form-inline">
                                                <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                                {{ csrf_field() }}
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($tipo == "juridica")
            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Pessoas<span class="sr-only">(current)</span></a>
                            <ul class="nav nav-pills nav-stacked"> 
                                <li style = "padding-left: 10px "><a href="/cadastro/cliente-fisica"> <span class="glyphicon glyphicon-menu-right"></span>  Clientes</a></li> 
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
                        <div class="panel-heading">Cadastro de Pessoas</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <tr>
                                        <td style="padding-bottom: 1em; padding-left: 1em;">
                                            <form method="post" action="/cadastro/pessoa_fisica/busca" class="form-inline" role="search">
                                                <div class="form-group">
                                                    <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                                </div>
                                                <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                                {{ csrf_field() }}
                                            </form>
                                        </td>

                                        <td style="padding-bottom: 1em;">
                                            <form method="get" action="/cadastro/juridica" class="form-inline">
                                                <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                                {{ csrf_field() }}
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($tipo == "cliente-fisica")

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

                        </div>
                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($tipo == "cliente-juridica")

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
                                        <form method="get" action="/cadastro/cliente-juridica" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>

                    </div>
                </div>
            </div>

            @endif

            @if($tipo == "fornecedor-fisica")
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

                            <table>
                                <tr>
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

                        </div>

                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>

                    </div>
                </div>
            </div>
            @endif

            @if($tipo == "fornecedor-juridica")
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

                            <table>
                                <tr>
                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/fornecedor_juridica/busca" class="form-inline" role="search">
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

                        </div>

                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>

                    </div>
                </div>
            </div>
            @endif

            @if($tipo == "usuario")
            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a></li>
                        <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Usuários<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Usuários</div>
                        <div class="panel-body">

                            <table>
                                <tr>
                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/usuario/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/usuario" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
