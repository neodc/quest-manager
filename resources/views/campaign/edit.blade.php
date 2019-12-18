@extends('layout.default')

<?php /** @var \App\Models\Campaign $campaign */ ?>
@section('content')
	<h2>@lang('campaign.edit.title')</h2>
	<div id="app">
		<form method="post" class="margin-bottom">
			{!! csrf_field() !!}
			<div class="form-group @if($errors->has('name')) has-error @endif">
				<label for="name">@lang('campaign.edit.name')</label>
				<input type="text" id="name" name="name" value="{{ old('name', $campaign->name) }}">
				@if($errors->has('name'))
					<ul class="form-errors">
						@foreach($errors->get('name') as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				@endif
			</div>
			<input type="submit" class="paper-btn btn-secondary" value="@lang('campaign.edit.submit')"/>
		</form>
		<h3>@lang('campaign.edit.access')</h3>
		<table>
			<tr>
				<th class="text-left">Name</th>
				<th class="text-left">Email</th>
				<th>Is DM</th>
				<th></th>
			</tr>
			@foreach($campaign->users as $user)
				<tr>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td class="text-center">
						@if(Auth::id() !== $user->id)
						<a class="no-link" href="{{ route($user->pivot->is_dm ? 'campaign.dm.unset' : 'campaign.dm.set', [$campaign, $user]) }}">
						@endif
							<i>{{ $user->pivot->is_dm ? '✅️' : '❌' }}</i>
						@if(Auth::id() !== $user->id)
						</a>
						@endif
					</td>
					<td class="text-right">
						@if(Auth::id() !== $user->id)
							<a href="{{ route('campaign.remove-player', [$campaign, $user]) }}" class="no-link">
								<i class="no-color">🗑️</i>
							</a>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
		<p>
			<label class="paper-btn margin" for="modal-invite">
				@lang('campaign.edit.invite.open_modal')
			</label>
		</p>

		<input class="modal-state" id="modal-invite" type="checkbox">
		<div class="modal">
			<label class="modal-bg" for="modal-invite"></label>
			<div class="modal-body">
				<label class="btn-close" for="modal-invite">X</label>
				<h4 class="modal-title">
					@lang('campaign.edit.invite.modal_title')
				</h4>
				<div class="form-group">
					<label for="invitation-url">@lang('campaign.edit.invite.instruction')</label>
					<input id="invitation-url" class="input-block" type="text" value="{{ route('invite', $campaign->invite_id) }}">
				</div>
				<p>
					<small>
						@lang('campaign.edit.invite.reset_instruction')
						<a href="{{ route('campaign.reset-link', $campaign) }}" class="paper-btn btn-danger btn-small">
							@lang('campaign.edit.invite.reset_btn')
						</a>
					</small>
				</p>
			</div>
		</div>
	</div>
@endsection
