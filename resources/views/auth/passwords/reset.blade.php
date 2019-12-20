@extends('layout.default')

@section('content')
	<h2>@lang('auth.reset-password.title')</h2>
	<form method="post">
		@csrf
		<input type="hidden" name="token" value="{{ $token }}">
		<div class="form-group @error('email') has-error @enderror">
			<label for="email">@lang('auth.reset-password.email')</label>
			<input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
			@error('email')
				<ul class="form-errors">
					@foreach($errors->get('email') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@enderror
		</div>
		<div class="form-group @error('password') has-error @enderror">
			<label for="password">@lang('auth.reset-password.password')</label>
			<input type="password" id="password" name="password" required autocomplete="new-password" minlength="8">
			@error('password')
				<ul class="form-errors">
					@foreach($errors->get('password') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@enderror
		</div>
		<div class="form-group @error('password') has-error @enderror">
			<label for="password_confirmation">@lang('auth.reset-password.password_confirmation')</label>
			<input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" minlength="8">
		</div>
		<input type="submit" class="paper-btn btn-secondary" value="@lang('auth.reset-password.submit')"/>
	</form>
@endsection
