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
				@can('update', $campaign)
					<a href="{{ route('campaign.edit', ['campaign' => $campaign]) }}" class="no-link"><i>✏️</i></a>
				@endcan
			</li>
		@endforeach
	</ul>
@endsection
