@extends('layouts.app')

@section('content')

<script type="text/javascript">
    
    window.onload = function() {
        document.getElementById('search').focus();
    };

</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
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
                        <div class="panel-heading">Cadastro de Marcas</div>
                        <div class="panel-body">
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="/cadastro/marca/cadastrar">
                                            <button type="submit" class="btn btn-primary">Nova Marca</button>
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/marca/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input id="search" type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" autofocus="true">
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
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Nome</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($marcas)
                                    @foreach($marcas as $marca)
                                    <tbody>
                                        <tr>
                                            <td>{{$marca->id}}</td>
                                            <td>{{$marca->nome}}</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                            <form method="GET" action="/cadastro/marca/{{$marca->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>
                                            
                                            <form method="GET" action="/cadastro/marca/{{$marca->id}}/delete"><button type="submit" class="btn btn-icon remove"><span class="glyphicon glyphicon-trash"></span></button></form>
                                            </div>
                                            </td>                                      
                                        </tr>
                                    </tbody>
                                    @endforeach
                                @endif
                            </TABLE>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
