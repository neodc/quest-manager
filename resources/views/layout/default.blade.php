@extends('layout.minimal')

@section('body')
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
					<li><a href="{{ route('campaign.list') }}">@lang('layout.campaign_list')</a></li>
					<li><a href="{{ route('logout') }}">@lang('layout.logout')</a></li>
				@else
					<li><a href="{{ route('login') }}">@lang('layout.login')</a></li>
					<li><a href="{{ route('register') }}">@lang('layout.register')</a></li>
				@endauth
			</ul>
		</div>
	</div>
</nav>
<div class="paper container">
	@yield('content')
</div>
@endsection
