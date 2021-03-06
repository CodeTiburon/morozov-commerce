<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>Laravel</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/Gritter-master/css/jquery.gritter.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css') }}">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('http://malsup.github.com/jquery.form.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/Gritter-master/js/jquery.gritter.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery/auth.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery/common.js') }}"></script>
</head>
<body>
	<nav class="navbar navbar-default {{ Request::is('admin') || Request::is('admin/*') ? 'admin' : '' }}">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">Lcommerce</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
                    @if( !(Request::is('admin') || Request::is('admin/*')) )
                        {{--<li><a href="{{ url('/categories') }}">Categories</a></li>--}}
                    @else
					    <li><a href="{{ url('/admin/categories') }}">Categories</a></li>
                    @endif
                    @if( !(Request::is('admin') || Request::is('admin/*')) )
                        {{--<li><a href="{{ url('/products') }}">Products</a></li>--}}
                    @else
                        <li><a href="{{ url('/admin/products') }}">Products</a></li>
                    @endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
                    @if( MyAuth::isAdmin() && !(Request::is('admin') || Request::is('admin/*')) )
                        <li><a class="admin-link" href="{{url('admin')}}">Admin Panel</a></li>
                    @endif
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-log-in"> </span>&nbsp;Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
                        <li>@include('minicart')</li>
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

</body>
</html>
