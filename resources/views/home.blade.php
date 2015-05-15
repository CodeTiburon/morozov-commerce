@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class=".col-xs-6 col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading">Categories</div>
                <div class="panel-body">
                    <div class="categories-menu">
                        @if( $categories )
                            <ul id="menu">
                                @foreach ($categories as $category)
                                    {!! RenderView::renderMenuNode($category) !!}
                                @endforeach
                            </ul>
                        @else
                            <span> There are no categories </span>
                        @endif
                        @if( MyAuth::isAdmin() )
                            <br/>
                            <a class="edit-category" href="{{Url('admin/categories/edit')}}">Edit categories</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class=".col-xs-12 col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">Products</div>
                <div class="panel-body">
                    @include('templates/product')
                    <div class="products">
                        <p class="empty"> Please choose a category. </p>
                    </div>
                    <div id="pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/lodash.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery/home.js') }}"></script>

@endsection
