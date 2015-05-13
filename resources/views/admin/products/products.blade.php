@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Products</div>
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
                            <th>Created At</th>
                            <th> </th>
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
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>{{ $product['price'] }} $</td>
                                    <td>{{ $product['created_at'] }}</td>
                                    <td><a class="link-to-product" href="{{ url('admin/products/edit').'/'.$product['id'] }}"> Edit </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <span>There are no products</span>
                    @endif
                </div>

			</div>
            <div class="add-new-block">
                <a class="add-new-product" href="{{ url('admin/products/add') }}">Add new product</a>
            </div>
		</div>
	</div>
</div>
@endsection
