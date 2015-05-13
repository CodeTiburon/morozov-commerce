@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Categories</div>

				<div class="panel-body">
                    <div class="products">
                        @if ($products)
                            @foreach ($products as $product)
                                <div class="product">
                                    <h3><a class="link-to-product" href="{{ url('products/show/').'/'.$product['id'] }}">{{ $product['name'] }}</a></h3>
                                    <p>{{ $product['model'] }}</p>
                                    <p><a class="link-to-product" href="{{ url('products/show/').'/'.$product['id'] }}"><img style="max-width:200px" src="{{ $product['image'] }}" alt="{{ $product['name'] }}"/></a></p>

                                    <p class="description">{{ $product['short_descr'] }} </p>

                                </div>
                            @endforeach
                        @else
                            <span>There are no products</span>
                        @endif
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
