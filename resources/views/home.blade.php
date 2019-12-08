@extends('layout.default')

@section('content')
	<div class="row flex-edges">
		<div class="col col-12">
			<h1>@lang('home.title')</h1>
			<p>@lang('home.description')</p>
		</div>
		<div class="col xs-12 sm-6">@lang('home.cols.1')</div>
		<div class="col xs-12 sm-6">@lang('home.cols.2')</div>
	</div>
@endsection
