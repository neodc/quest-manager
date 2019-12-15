@extends('layout.minimal')

<?php /** @var \App\Models\Campaign $campaign */ ?>
@section('body')
<div id="app" class="play-container">
	<h2>{{ $campaign->name }}</h2>
	<play
		:url_update="'{{ route('api.campaign.detail', [$campaign]) }}'"
		:url_edit_step="'{{ route('api.step.edit', [':step']) }}'"
		:url_visibility_step="'{{ route('api.step.visibility', [':step']) }}'"
		:url_state_step="'{{ route('api.step.state', [':step']) }}'"
		:url_edit_comment="'{{ route('api.comment.edit', [':comment']) }}'"
		:url_visibility_comment="'{{ route('api.comment.visibility', [':comment']) }}'"
	></play>
</div>
@endsection
