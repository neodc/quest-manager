@extends('layout.minimal')

<?php /** @var \App\Models\Campaign $campaign */ ?>
@section('body')
<div id="app" class="play-container">
	<h2>{{ $campaign->name }}</h2>
	<play
		:broadcast_channel="'{{ $channel }}'"
		:url_update="'{{ route('api.campaign.detail', [$campaign]) }}'"
		:url_quest_add="'{{ route('api.quest.add') }}'"
		:url_quest="'{{ route('api.quest.edit', [':quest']) }}'"
		:url_quest_visibility="'{{ route('api.quest.visibility', [':quest']) }}'"
		:url_step="'{{ route('api.step.edit', [':step']) }}'"
		:url_step_reorder="'{{ route('api.step.reorder') }}'"
		:url_step_add="'{{ route('api.step.add') }}'"
		:url_step_visibility="'{{ route('api.step.visibility', [':step']) }}'"
		:url_step_state="'{{ route('api.step.state', [':step']) }}'"
		:url_comment="'{{ route('api.comment.edit', [':comment']) }}'"
		:url_comment_visibility="'{{ route('api.comment.visibility', [':comment']) }}'"
		:url_comment_add="'{{ route('api.comment.add') }}'"
		:url_resource="'{{ route('api.resource.edit', [':resource']) }}'"
		:url_resource_visibility="'{{ route('api.resource.visibility', [':resource']) }}'"
		:url_resource_add="'{{ route('api.resource.add') }}'"
		:startup_campaign_data="{{ json_encode($campaignData) }}"
	></play>
</div>
@endsection
