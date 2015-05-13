@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add product</div>
                    <div class="panel-body">
                        <div class="add-product">
                            {!! Form::open(array('action' => 'Admin\ProductAddController@create','method'=>'POST', 'class' => '-dropzone', 'files'=>true)) !!}
                            <input id="token" type="hidden" name="_token" value="{{ \MyAuth::tokenEncrypt() }}">
                            <div class="form-group">
                                {!! Form::label('category','category:') !!}
                                {{--{!! Form::select('category', $categories, null, ['class' => 'form-control']) !!}--}}
                                <br/>
                                <select class = "categorySelect" multiple="multiple" name="category[]">
                                    @foreach ($categories as $category)
                                        {!! RenderView::renderSelect($category) !!}
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('name','name:') !!}
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('model','model:') !!}
                                {!! Form::text('model', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('description','description:') !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('price','price($):') !!}
                                <br />
                                <input id="price" type="number" min="0" step="0.01" value="0.00" name="price">
                            </div>
                            <div class="form-group">
                                {!! Form::label('quantity','quantity:') !!}
                                <br />
                                <input id="quantity" type="number" min="0"  step="1" value="1" name="quantity">
                            </div>
                            <div class="form-group">
                                {!! Form::label('image','load image:') !!}
                                {!! Form::file('images[]', array('multiple'=>true, 'class' => 'a-images')) !!}
                                <input id="primary-image" type="hidden" name="primary-image" value="1">
                                <p class="errors">{!!$errors->first('images')!!}</p>
                                @if(Session::has('error'))
                                    <p class="errors">{!! Session::get('error') !!}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="cat-rmv-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to remove a category?</p>
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
    <link href="{{ asset('/assets/dropzone-master/dist/dropzone.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ URL::asset('/assets/fancyBox/source/jquery.fancybox.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/arendjr-selectivity/dist/selectivity-full.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/elevatezoom-master/jquery.elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/dropzone-master/dist/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery/product.js') }}"></script>
@endsection
