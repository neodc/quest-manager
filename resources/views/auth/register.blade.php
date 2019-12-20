@extends('layout.default')

@section('content')
	<h2>@lang('auth.register.title')</h2>
	<form method="post">
		@csrf
		<div class="form-group @error('name') has-error @enderror">
			<label for="name">@lang('auth.register.name')</label>
			<input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name">
			@error('name')
				<ul class="form-errors">
					@foreach($errors->get('name') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@enderror
		</div>
		<div class="form-group @error('email') has-error @enderror">
			<label for="email">@lang('auth.register.email')</label>
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
			<label for="password">@lang('auth.register.password')</label>
			<input type="password" id="password" name="password" required autocomplete="new-password">
			@error('password')
				<ul class="form-errors">
					@foreach($errors->get('password') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@enderror
		</div>
		<div class="form-group @error('password') has-error @enderror">
			<label for="password_confirmation">@lang('auth.register.password_confirmation')</label>
			<input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
		</div>
		<input type="submit" class="paper-btn btn-secondary" value="@lang('auth.register.submit')"/>
	</form>
@endsection
