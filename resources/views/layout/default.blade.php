<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<script src="{{ asset('js/app.js') }}" type="application/javascript"></script>
	<title>Document</title>
</head>
<body>
<div id="app" class="paper container">
	<div
		class="text-right padding-left-large padding-right-large padding-top-small padding-bottom-small background-primary"
		style="margin: -2rem; border-bottom: solid 2px black"
	>
		@auth
			<a href="#" class="paper-btn btn-muted">@lang('layout.logout')</a>
		@else
			<a href="#" class="paper-btn btn-muted">@lang('layout.login')</a>
			<a href="#" class="paper-btn btn-muted">@lang('layout.register')</a>
		@endauth
	</div>
	<div class="row flex-edges">
		@yield('content')
	</div>
</div>
</body>
</html>
