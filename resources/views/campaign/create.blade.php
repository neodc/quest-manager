@extends('layout.default')

@section('content')
	<h2>@lang('campaign.create.title')</h2>
	<form method="post">
		{!! csrf_field() !!}
		<div class="form-group @if($errors->has('name')) has-error @endif">
			<label for="name">@lang('campaign.create.name')</label>
			<input type="text" id="name" name="name" value="{{ old('name') }}">
			@if($errors->has('name'))
				<ul class="form-errors">
					@foreach($errors->get('name') as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif
		</div>
		<input type="submit" class="paper-btn btn-secondary" value="@lang('campaign.create.submit')"/>
	</form>
@endsection
