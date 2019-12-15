@extends('layout.minimal')

<?php /** @var \App\Models\Campaign $campaign */ ?>
@section('body')
<div id="app" class="play-container">
	<h2>{{ $campaign->name }}</h2>
	<play
		:url_update="'{{ route('api.campaign.detail', [$campaign]) }}'"
		:url_edit_step="'{{ route('api.step.edit', [':step']) }}'"
		:url_edit_comment="'{{ route('api.comment.edit', [':comment']) }}'"
	></play>
	{{--<div class="play-space">
		<div class="play-quest-list">
			<ul>
				<li class="active"><a href="#">Quest 1</a></li>
				<li><a href="#">Quest 2</a></li>
				<li><a href="#">Quest 3</a></li>
				<li><a href="#">Quest 4</a></li>
				<li><a href="#">Quest 5</a></li>
				<li><a href="#">Quest 6</a></li>
				<li><a href="#">Quest 101010101010101011010101010101010110101010101010101</a></li>
			</ul>
			<a class="paper-btn btn-small btn-block text-center" href="#">Add more</a>
		</div>
		<div class="play-quest">
			<div class="play-step-list">
				<div class="play-step state-done">
					<h4>
						Step done
						<span class="play-step-actions-player">
							<a href="#" title="todo"><i>📋</i></a> --}}{{-- todo --}}{{--
							<a href="#" title="in progress"><i>⏳</i></a> --}}{{-- in progress --}}{{--
							<a href="#" title="done"><i>🏅</i></a> --}}{{-- done --}}{{--
							<a href="#" title="hidden"><i>🚷</i></a> --}}{{-- Visible --}}{{--
							<a href="#" title="visible"><i>🚹</i></a> --}}{{-- Visible --}}{{--
						</span>
						<span class="play-step-actions-dm">
							<a href="#" title="edit"><i>✏️</i></a> --}}{{-- Edit --}}{{--
								<a href="#" title="delete"><i>❌</i></a> --}}{{-- Delete --}}{{--
						</span>
					</h4>
					<div class="player-content">
						<p>@lang('home.cols.1')</p>
						<p>@lang('home.cols.2')</p>
					</div>
					<div class="dm-content">
						<hr>
						<p>@lang('home.cols.1')</p>
						<p>@lang('home.cols.2')</p>
					</div>
				</div>
				<div class="play-step state-in-progress">
					<h4>Step in progress</h4>
					<div class="player-content">
						<p>Player content</p>
					</div>
					<div class="dm-content">
						<hr>
						<p>DM content</p>
					</div>
				</div>
				<div class="play-step state-todo">
					<h4>Step todo</h4>
					<div class="player-content">
						<p>Player content</p>
					</div>
					<div class="dm-content">
						<hr>
						<p>DM content</p>
					</div>
				</div>

				<p class="play-step-add">
					<a href="#" class="paper-btn btn-small">
						<i>➕</i>
					</a>
				</p>
			</div>
			<div class="play-comment-list">
				<div class="play-comment">
					<h5>
						Name
						<span class="play-step-actions-player">
							<a href="#"><i>⤴️</i></a> --}}{{-- link to step --}}{{--
							<a href="#" title="hidden"><i>🚷</i></a> --}}{{-- Visible --}}{{--
							<a href="#" title="visible"><i>🚹</i></a> --}}{{-- Visible --}}{{--
						</span>
						<span class="play-step-actions-dm">
							<a href="#" title="edit"><i>✏️</i></a> --}}{{-- Edit --}}{{--
								<a href="#" title="delete"><i>❌</i></a> --}}{{-- Delete --}}{{--
						</span>
						<br>
						<small>2019-12-08 21:00:00</small>
					</h5>

					<div class="player-content">
						<p>@lang('home.cols.1')</p>
						<p>@lang('home.cols.2')</p>
					</div>
					<div class="dm-content">
						<hr>
						<p>@lang('home.cols.1')</p>
						<p>@lang('home.cols.2')</p>
					</div>
				</div>
				<div class="play-comment type-event">
					<h5>
						Something append!
						<span class="play-step-actions-player">
							<a href="#" title="hidden"><i>🚷</i></a> --}}{{-- Visible --}}{{--
							<a href="#" title="visible"><i>🚹</i></a> --}}{{-- Visible --}}{{--
						</span>
						<span class="play-step-actions-dm">
							<a href="#" title="edit"><i>✏️</i></a> --}}{{-- Edit --}}{{--
								<a href="#" title="delete"><i>❌</i></a> --}}{{-- Delete --}}{{--
						</span>
						<br>
						<small>2019-12-08 21:00:00</small>
					</h5>
				</div>
				<p class="play-comment-add">
					<a href="#" class="paper-btn btn-small">
						<i>➕</i>
					</a>
				</p>
			</div>
		</div>
	</div>--}}
</div>
@endsection
