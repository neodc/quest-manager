<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	@if(isset($needJs) && $needJs)
		<script src="{{ asset('js/app.js') }}" type="application/javascript"></script>
	@endif
	<title>Document</title>
</head>
<body>
<nav class="border split-nav">
	<div class="nav-brand">
		<h3><a href="/">@lang('home.title')</a></h3>
	</div>
	<div class="collapsible">
		<input id="collapsible1" type="checkbox" name="collapsible1">
		<button>
			<label for="collapsible1">
				<div class="bar1"></div>
				<div class="bar2"></div>
				<div class="bar3"></div>
			</label>
		</button>
		<div class="collapsible-body">
			<ul class="inline">
				@auth
					<li><a href="{{ route('logout') }}">@lang('layout.logout')</a></li>
				@else
					<li><a href="{{ route('login') }}">@lang('layout.login')</a></li>
					<li><a href="{{ route('register') }}">@lang('layout.register')</a></li>
				@endauth
			</ul>
		</div>
	</div>
</nav>
<div id="app" class="paper container">
	<div class="row flex-edges">
		@yield('content')
	</div>
</div>
</body>
</html>
