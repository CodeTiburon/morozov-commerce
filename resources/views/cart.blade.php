@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Cart</div>
                <div class="panel-body">
                    @if ($products)
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Model</th>
                            <th>Short Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product['id'] }}</td>
                                    <td><a class="link-to-product" href="{{ url('admin/products/edit').'/'.$product['id'] }}"><img style="max-width:100px" src="{{ asset('uploads/'.$product['image'] ) }}" alt="{{ $product['name'] }}"/></a></td>
                                    <td><a class="link-to-product" href="{{ url('admin/products/edit').'/'.$product['id'] }}">{{ $product['name'] }}</a></td>
                                    <td>{{ $product['model'] }}</td>
                                    <td>{{ substr($product['description'], 0, 25) }} ...</td>
                                    <td>
                                        {!! Form::open(array('url' => 'checkout/cart/qty-update','method'=>'POST', 'class' => 'quantity-number')) !!}
                                        <div class="form-group float">
                                            <input id="quantity" type="number" min="0" max="999" step="1" value="{{ $product['quantity'] }}" name="quantity">
                                            <input id="product-id" type="hidden" name="product_id" value="{{ $product['id'] }}">
                                        </div>
                                        <div class="form-group float">
                                            <button id="quantity-update" name="quantity_update" class="glyphicon glyphicon-ok-sign"></button>
                                        </div>
                                        {!! Form::close() !!}
                                        <div class="form-group float">
                                            <button id="remove-product" data-id="{{ $product['id'] }}" name="remove_product" class="glyphicon glyphicon-remove-sign"></button>
                                        </div>
                                    </td>
                                    <td><span>{{ $product['price_total'] }} $</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <div class="total">
                            <p>Total sum: <span class="price"> {{ MyHelpers::cartTotalSum() }} $</span></p>
                            <div class="add-new-block">
                                <a class="add-new-product btn btn-default" href="{{ url('admin/products/add') }}">Checkout</a>
                            </div>
                        </div>
                    @else
                        <span>There are no products</span>
                    @endif
                </div>
			</div>
            <a id="clear-cart" href="#">Clear cart</a>
		</div>
	</div>
</div>
@endsection
