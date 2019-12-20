<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddComment;
use App\Http\Requests\EditComment;
use App\Http\Requests\Visibility;
use App\Models\Comment;
use App\Models\Quest;
use App\Models\Resource;
use App\Models\User;
use App\Rules\Exists;
use App\Services\CampaignService;

class CommentController extends Controller
{
	public function add(AddComment $request, CampaignService $campaignService)
	{
		$quest = Quest::findOrFail($request->get('quest_id'));
		$this->authorize('view', $quest);

		/** @var User $user */
		$user = \Auth::user();
		$isDm = $user->campaigns()->newPivotStatementForId($quest->campaign_id)->first()->is_dm;

		Comment::forceCreate(
			[
				'resource_id' => $request->get('resource_id'),
				'player_text' => $request->get('player_text') ?? '',
				'dm_text' => $request->get('dm_text') ?? '',
				'type' => $request->get('type') ?? 'message',
				'quest_id' => $request->get('quest_id'),

				'is_visible' => !$isDm,
				'user_id' => \Auth::id(),
			]
		);

		$campaignService->broadcastUpdate($quest->campaign_id);
	}

	public function edit(Comment $comment, EditComment $request, CampaignService $campaignService)
	{
		$this->authorize('update', $comment);

		$this->validate(
			$request,
			[
				'resource_id' => [
					'nullable',
					(new Exists(Resource::class))
						->where('campaign_id', $comment->quest()->value('campaign_id')),
				]
			]
		);

		$comment->resource_id = $request->resource_id;
		$comment->player_text = $request->player_text ?? '';
		$comment->dm_text= $request->dm_text ?? '';

		$comment->save();

		$campaignService->broadcastUpdate($comment->quest->campaign_id);
	}

	public function delete(Comment $comment, CampaignService $campaignService)
	{
		$this->authorize('update', $comment);

		$comment->delete();

		$campaignService->broadcastUpdate($comment->quest->campaign_id);
	}

	public function visibility(Comment $comment, Visibility $request, CampaignService $campaignService)
	{
		$this->authorize('update', $comment);

		$comment->is_visible = $request->is_visible;

		$comment->save();

		$campaignService->broadcastUpdate($comment->quest->campaign_id);
	}
}
