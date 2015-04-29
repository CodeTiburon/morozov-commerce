@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Categories</div>
                    <ul class="edit-category">
                        @foreach ($categories as $category)
                            {!! RenderView::renderNode($category) !!}
                        @endforeach
                    </ul>
                </div>
                <div class="add-category" style="display:{{ is_null($categories) ? 'block' : 'none' }}">
                    {!! Form::open(['action' => 'Admin\CategoryEditController@create']) !!}
                    <input id="token" type="hidden" name="_token" value="{{ \MyAuth::tokenEncrypt() }}">
                    <div class="form-group">
                        {!! Form::label('name','Category name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                    {!! Form::close() !!}
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
    <script type="text/javascript" src="{{ URL::asset('js/jquery/category.js') }}"></script>
@endsection
