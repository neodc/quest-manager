<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<title>Document</title>
</head>
<body>
@if(isset($needJs) && $needJs)
	<script>
		vue = {
			el: '#app',
			delimiters: ['${', '}'],
			data: {},
			methods: {},
		};
	</script>
@endif

@yield('body')

@if(isset($needJs) && $needJs)
	<script src="{{ asset('js/app.js') }}" type="application/javascript"></script>
@endif
</body>
</html>
