@extends('layout.default')

@section('content')
	<h2>@lang('auth.forgot-password.title')</h2>
	<form method="post">
		@csrf
		<div class="form-group @error('email') has-error @enderror">
			<label for="email">@lang('auth.forgot-password.email')</label>
			<input type="email" id="email" name="email" value="{{ old('email') }}">
			@error('email')
				<ul class="form-errors">
					@foreach($errors->get('email') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@enderror
		</div>
		<input type="submit" class="paper-btn btn-secondary" value="@lang('auth.forgot-password.submit')" required autocomplete="email"/>
		<p>
			<a href="{{ route('login') }}">
				@lang('auth.forgot-password.login')
			</a>
		</p>
	</form>
@endsection
