@extends('layout.default')

@section('content')
	<h2>@lang('campaign.create.title')</h2>
	<form method="post">
		@csrf
		<div class="form-group @error('name') has-error @enderror">
			<label for="name">@lang('campaign.create.name')</label>
			<input type="text" id="name" name="name" value="{{ old('name') }}" required>
			@error('name')
				<ul class="form-errors">
					@foreach($errors->get('name') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@enderror
		</div>
		<input type="submit" class="paper-btn btn-secondary" value="@lang('campaign.create.submit')"/>
	</form>
@endsection
