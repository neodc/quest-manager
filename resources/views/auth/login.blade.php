@extends('layout.default')

@section('content')
	<div class="col col-12">
		<h2>@lang('auth.login.title')</h2>
		<form method="post">
			{!! csrf_field() !!}
			<div class="form-group @if($errors->has('email')) has-error @endif">
				<label for="email">@lang('auth.login.email')</label>
				<input type="email" id="email" name="email" value="{{ old('email') }}">
				@if($errors->has('email'))
					<ul class="form-errors">
						@foreach($errors->get('email') as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				@endif
			</div>
			<div class="form-group @if($errors->has('password')) has-error @endif">
				<label for="password">@lang('auth.login.password')</label>
				<input type="password" id="password" name="password">
				@if($errors->has('password'))
					<ul class="form-errors">
						@foreach($errors->get('password') as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				@endif
			</div>
			<input type="submit" class="paper-btn btn-secondary" value="@lang('auth.login.submit')"/>
		</form>
	</div>
@endsection
