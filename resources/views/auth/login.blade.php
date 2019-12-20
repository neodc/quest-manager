@extends('layout.default')

@section('content')
	<h2>@lang('auth.login.title')</h2>
	<form method="post">
		@csrf
		<div class="form-group @error('email') has-error @enderror">
			<label for="email">@lang('auth.login.email')</label>
			<input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
			@error('email')
				<ul class="form-errors">
					@foreach($errors->get('email') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@enderror
		</div>
		<div class="form-group @error('password') has-error @enderror">
			<label for="password">@lang('auth.login.password')</label>
			<input type="password" id="password" name="password" required autocomplete="current-password">
			@error('password')
				<ul class="form-errors">
					@foreach($errors->get('password') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@enderror
		</div>
		<input type="submit" class="paper-btn btn-secondary" value="@lang('auth.login.submit')"/>
		<p>
			<a href="{{ route('password.forgot') }}">
				@lang('auth.login.forgot')
			</a>
		</p>
	</form>
@endsection
