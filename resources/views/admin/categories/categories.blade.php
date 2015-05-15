@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Categories</div>

				<div class="panel-body">
                    @if( $categories )
                        <ul>
                            @foreach ($categories as $category)
                                {!! RenderView::renderNode($category) !!}
                            @endforeach
                        </ul>
                        <div class="pagination">{!! $plinks !!}</div>
                    @else
                        <span> There are no categories </span>
                    @endif
                        @if( MyAuth::isAdmin() )
                            <a class="edit-category" href="{{Url('admin/categories/edit')}}">Edit</a>
                        @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
