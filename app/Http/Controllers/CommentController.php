<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditComment;
use App\Http\Requests\VisibilityComment;
use App\Models\Comment;
use App\Models\Resource;
use App\Rules\Exists;

class CommentController extends Controller
{
	public function edit(Comment $comment, EditComment $request)
	{
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
		$comment->player_text = $request->player_text;
		$comment->dm_text= $request->dm_text ?? '';

		$comment->save();
	}

	public function delete(Comment $comment)
	{
		$comment->delete();
	}

	public function visibility(Comment $comment, VisibilityComment $request)
	{
		$comment->is_visible = $request->is_visible;

		$comment->save();
	}
}
