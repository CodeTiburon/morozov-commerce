@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $product['name'] }}</div>
                    <div class="panel-body">
                        <div class="breadcrumbs">
                            @foreach ($categories as $category)
                                {!! RenderView::renderBreadcrumbs($category, $product['categories']) !!}
                            @endforeach
                        </div>
                        <div class="gallary">
                            <div class="main-image">
                                <a class="fancybox-thumb" rel="fancybox-thumb" data-zoom-image="{{ asset('uploads/'.$product['image']) }}" href="{{ asset('uploads/'.$product['image']) }}" title="{{ $product['name'] }}">
                                    <img data-id="{{ $product['image_id'] }}" style="max-width:400px" src="{{ asset('uploads/'.$product['image']) }}" alt="{{ $product['name'] }}" />
                                </a>
                            </div>
                            <div class="thumbnails">
                                {{--{{ dd($product['thumbs']) }}--}}
                                @foreach ($product['thumbs'] as $img)
                                    <div class="thumb">
                                        <a class="fancybox-thumb" rel="fancybox-thumb" data-zoom-image="{{ asset('uploads/'.$product['image']) }}" href="{{ asset('uploads/'.$img->image) }}" title="{{ $product['name'] }}">
                                            <img style="max-width:150px" src="{{ asset('uploads/'.$img->image) }}" alt="{{ $product['name'] }}"/>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="product-price">
                            Price: <span class="price">{{  $product['price'] }}</span>
                        </div>

                        <div class="description">
                            {{ $product['description'] }}
                        </div>

                    </div>
                </div>
                <div class="add-new-block">
                    <a class="add-new-product" href="{{ url('home') }}"> Back to product list </a>
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
    <link href="{{ asset('/assets/lightbox/css/lightbox.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/arendjr-selectivity/dist/selectivity-full.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ URL::asset('/assets/fancyBox/source/jquery.fancybox.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/lightbox/js/lightbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/arendjr-selectivity/dist/selectivity-full.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/elevatezoom-master/jquery.elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery/product.js') }}"></script>
@endsection
