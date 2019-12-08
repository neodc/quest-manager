@extends('layout.default')

@section('content')
	<h2>
		@lang('campaign.list.title.select')
		<small>
			@lang('campaign.list.title.or')
			<a href="{{ route('campaign.create') }}">
				@lang('campaign.list.title.create')
			</a>
		</small>
	</h2>
	<ul>
		@foreach($campaigns as $campaign)
			<li>
				<a>{{ $campaign->name }}</a>
			</li>
		@endforeach
	</ul>
@endsection
