@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Categories</div>

				<div class="panel-body">
                    <ul>
                        @foreach ($categories as $category)
                            {!! RenderView::renderNode($category) !!}
                        @endforeach
                    </ul>
                    @if( MyAuth::isAdmin() )
                        <a class="edit-category" href="{{Url('admin/categories/edit')}}">Редактировать категории</a>
                    @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
