@extends('layout')
@section('header')
<div class="page-header">
        <h1>Sells / Show #{{$sell->id}}</h1>
        <form action="{{ route('sells.destroy', $sell->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                {{-- <button type="submit" class="btn btn-danger">Delete <i class="glyphicon glyphicon-trash"></i></button> --}}
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-link" href="{{ route('sells.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
        </div>
        <div class="col-md-4">
            <form action="#">
                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$sell->id}}</p>
                </div>
                <div class="form-group">
                    <label for="nome">Cliente</label>
                    <p class="form-control-static">{{$sell->client}}</p>
                </div>
                <div class="form-group">
                    <label for="nome">Modo de Pagamento</label>
                    <p class="form-control-static">{{$sell->payment_method}}</p>
                </div>
                <div class="form-group">
                    <label for="nome">Valor Pago</label>
                    <p class="form-control-static">{{$sell->paid}}</p>
                </div>
                <div class="form-group">
                    <label for="nome">Data da Compra</label>
                    <p class="form-control-static">{{$sell->created_at}}</p>
                </div>
            </form>


        </div>
        <div class="col-md-8">
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>VALOR</th>
                        <th>QUANTIDADE</th>
                        <th>ARTESÃO</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($sell->products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->pivot->value}}</td>
                            <td>{{$product->pivot->amount}}</td>
                            <td>{{$product->artisan->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="lead"><strong>TOTAL</strong> <span class="pull-right" id="total-value"> {{$total}} </span></p>
    </div>

@endsection