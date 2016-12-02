@extends('layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-plus"></i> Sells / Create </h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('sells.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('client')) has-error @endif">
                    <label for="client-field">Cliente</label>
                    <input type="text" id="client-field" name="client" class="form-control" value="{{ old("client") }}"/>
                    @if($errors->has("client"))
                        <span class="help-block">{{ $errors->first("client") }}</span>
                    @endif
                </div>
                <h3>Produtos</h3>
                <hr/>
                <div class="form-group product-search">
                    <input type="text" class="form-control product-search-field" placeholder="Digite o Nome do Produto" />
                    <input type="hidden" class="product-id" />
                    <input type="hidden" class="product-name" />
                    <input type="hidden" class="product-amount" />
                    <input type="hidden" class="product-value" />
                    <button class="btn btn-primary add-product" disabled="disabled">Adicionar Produto</button>
                </div>
                <div>
                    <table id="product-list" class="table">
                        <tr>
                            <td>#</td>
                            <td>Nome</td>
                            <td>Quantidade</td>
                            <td>Valor</td>
                            <td></td>
                        </tr>
                    </table>
                </div>

                <p class="lead"><strong>TOTAL</strong> <span class="pull-right" id="total-value"> 0.00</span></p>

                <div class="form-group @if($errors->has('payment_method')) has-error @endif">
                    <label for="payment_method-field">Método de Pagamento</label>
                    <select id="payment_method-field" name="payment_method" class="form-control">
                        <option value="">Selecione</option>
                        <option value="dinheiro">Dinheiro</option>
                        <option value="credito">Cartão de Crédito</option>
                        <option value="debito">Cartão de Débito</option>
                        <option value="cheque">Cheque</option>
                    </select>
                    @if($errors->has("payment_method"))
                        <span class="help-block">{{ $errors->first("payment_method") }}</span>
                    @endif
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary btn-lg">Concluir Venda</button>
                    <a class="btn btn-link pull-right" href="{{ route('sells.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    var selectedProducts = [];
    var options = {
        url: "search",

        getValue: function(element) {
            return '['+element.id+'] - '+element.name;
        },

        list: {
            match: {
                enabled: true
            },

            onClickEvent: function() {
                var id = $('.product-search-field').getSelectedItemData().id;
                var name = $('.product-search-field').getSelectedItemData().name;
                var amount = $('.product-search-field').getSelectedItemData().amount;
                var value = $('.product-search-field').getSelectedItemData().value;

                $('.add-product').removeAttr('disabled');

                $('.product-id').val(id);
                $('.product-name').val(name);
                $('.product-amount').val(amount);
                $('.product-value').val(value);
            }
        },

        theme: "square"
    };

    $('.product-search-field').easyAutocomplete(options);

    $('body').on('click', '.add-product', function() {
        var id = $('.product-id').val();
        var name = $('.product-name').val();
        var amount = $('.product-amount').val();
        var value = $('.product-value').val();
        
        if($.inArray(id, selectedProducts) != "0") {
            if(amount > 0) {
                selectedProducts.push(id);

                $('#product-list').append(
                    '<tr>'+
                        '<td> <input type="hidden" class="product-table-id" data-id="'+id+'" name="product['+id+']" />'+ id +'</td>'+
                        '<td> '+ name +'</td>'+
                        '<td> <input class="product-table-amount" type="number" value="1" min="1" max="'+amount+'" name="product['+id+'][amount]"> </td>'+
                        '<td> <input class="product-table-value" type="text" name=product['+id+'][value] value="'+value+'"/></td>'+
                        '<td> <button class="btn btn-danger remove-product" type="submit"> Remover </button> </td>'+
                    '</tr>'
                );

                totalValue();        
            }
        }

        $('.product-search-field').val('');
        $(this).attr('disabled', 'disabled');

        return false;
    });

    $('#product-list').on('click', '.remove-product', function() {
        var id = $(this).parents('tr').find('.product-table-id').data('id');

        selectedProducts.remove(id+"");

        $(this).parents('tr').remove();

        totalValue();
    });

    $('body').on('click', '.product-table-amount', function() {
        totalValue();
    });

    $('body').on('change', '.product-table-value', function() {
        totalValue();
    });

    function totalValue()
    {
        var totalValue = 0;
        var value = 0;
        var amount = 0;

        $('.product-table-value').each(function(key, el) {
            amount = $(el).parents('tr').find('.product-table-amount').val();
            value = $(el).val();

            totalValue += value * amount;
        });

        $('#total-value').html(totalValue);
    }

  </script>
@endsection
