@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $product['name'] }}</div>
                    <div class="panel-body">

                        <div id="gallary">
                            <div class="main-image">
                                <a class="fancybox-thumb" rel="fancybox-thumb" data-zoom-image="{{ asset('uploads/'.$product['image']) }}" href="{{ asset('uploads/'.$product['image']) }}" title="{{ $product['name'] }}">
                                    <img data-id="{{ $product['image_id'] }}" style="max-width:400px" src="{{ asset('uploads/'.$product['image']) }}" alt="{{ $product['name'] }}" />
                                </a>
                            </div>
                            <div class="thumbnails gridly">
                                {{--{{ dd($product['thumbs']) }}--}}
                                @foreach ($product['thumbs'] as $img)
                                    <div class="thumb brick">
                                        <button data-id="{{ $img->id }}" class="btn btn-default set-as-main" type="button">Set as main</button>
                                        <a class="fancybox-thumb" rel="fancybox-thumb" data-zoom-image="{{ asset('uploads/'.$product['image']) }}" href="{{ asset('uploads/'.$img->image) }}" title="{{ $product['name'] }}">
                                            <img style="max-width:150px" src="{{ asset('uploads/'.$img->image) }}" alt="{{ $product['name'] }}"/>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{--<div class="gridly">--}}
                            {{--<div class="brick small"></div>--}}
                            {{--<div class="brick small"></div>--}}
                            {{--<div class="brick large"></div>--}}
                            {{--<div class="brick small"></div>--}}
                            {{--<div class="brick small"></div>--}}
                            {{--<div class="brick large"></div>--}}
                        {{--</div>--}}

                        <div class="edit-product">
                            {!! Form::open(array('action' => 'Admin\ProductEditController@edit','method'=>'POST', 'files'=>true)) !!}
                            <input id="token" type="hidden" name="_token" value="{{ \MyAuth::tokenEncrypt() }}">
                            <div class="form-group">
                                {!! Form::label('category','category:') !!}
                                {{--{!! Form::select('category', $categories, null, ['class' => 'form-control']) !!}--}}
                                <br/>
                                <select class = "categorySelect" multiple="multiple" name="category[]">
                                    @foreach ($categories as $category)
                                        {!! RenderView::renderSelect($category, $product['categories']) !!}
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('name','name:') !!}
                                {!! Form::text('name', $product['name'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('model','model:') !!}
                                {!! Form::text('model', $product['model'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('description','description:') !!}
                                {!! Form::textarea('description', $product['description'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('price','price($):') !!}
                                <br />
                                <input id="price" type="number" min="0" step="0.01" value="{{ $product['price'] }}" name="price">
                            </div>
                            <div class="form-group">
                                {!! Form::label('quantity','quantity:') !!}
                                <br />
                                <input id="quantity" type="number" min="0" max="999" step="1" value="{{ $product['quantity'] }}" name="quantity">
                            </div>
{{--                            <div class="form-group">
                                {!! Form::label('image','load image:') !!}
                                {!! Form::file('images[]', array('multiple'=>true, 'class' => 'a-images')) !!}
                                <input id="primary-image" type="hidden" name="primary-image" value="1">
                                <p class="errors">{!!$errors->first('images')!!}</p>
                                @if(Session::has('error'))
                                    <p class="errors">{!! Session::get('error') !!}</p>
                                @endif
                            </div>--}}
                            <input id="primary-image-id" type="hidden" name="primary_image_id" value="{{ $product['image_id'] }}">
                            <div class="form-group">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                            </div>
                            <input id="product-id" type="hidden" name="id" value="{{ $product['id'] }}">
                            {!! Form::close() !!}

                        </div>

                        <button data-product_id="{{ $product['id'] }}" class="btn btn-danger" id="product-remove" type="button">Remove product</button>

                    </div>
                </div>
                <div class="add-new-block">
                    <a class="add-new-product" href="{{ url('admin/products') }}"> Back to product list </a>
                </div>
            </div>
        </div>
    </div>
    <div id="product-rmv-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to remove a product?</p>
                    <p class="text-warning"><small>If you save, you couldn't restore this.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Remove</button>
                </div>
            </div>
        </div>
    </div>
    <link href="{{ asset('/assets/fancyBox/source/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/arendjr-selectivity/dist/selectivity-full.min.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('/assets/gridly/stylesheets/jquery.gridly.css') }}" rel="stylesheet">--}}
    <script type="text/javascript" src="{{ URL::asset('/assets/fancyBox/source/jquery.fancybox.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/arendjr-selectivity/dist/selectivity-full.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/elevatezoom-master/jquery.elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/dropzone-master/dist/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/gridly/javascripts/jquery.gridly.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery/product.js') }}"></script>
@endsection
