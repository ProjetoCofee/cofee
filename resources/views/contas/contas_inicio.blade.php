@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Contas</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="#">Início<span class="sr-only">(current)</span></a></li>
                            <li><a href="/contas/despesas">Despesas<span class="sr-only">(current)</span></a></li>
                            <li><a href="/contas/recebimentos">Recebimentos<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Página Inicial</div>
                        <div class="panel-body">
<!--  -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
