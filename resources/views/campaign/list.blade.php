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
				<a href="{{ route('campaign.play', ['campaign' => $campaign]) }}">{{ $campaign->name }}</a>
				<a href="{{ route('campaign.edit', ['campaign' => $campaign]) }}" class="no-link"><i>✏️</i></a>
			</li>
		@endforeach
	</ul>
@endsection
