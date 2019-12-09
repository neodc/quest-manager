<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCampaign;
use App\Models\Campaign;
use App\Models\User;

class CampaignController extends Controller
{
    public function list()
	{
		return view(
			'campaign.list',
			[
				'campaigns' => \Auth::user()->campaigns,
			]
		);
	}

    public function getCreate()
	{
		return view('campaign.create');
	}

    public function postCreate(CreateCampaign $request)
	{
		\Auth::user()->campaigns()->create(
			['name' => $request->get('name')],
			['is_dm' => true]
		);

		return redirect()->route('campaign.list');
	}

	public function play(Campaign $campaign)
	{
		return view(
			'campaign.play',
			[
				'needJs' => true,
				'campaign' => $campaign,
			]
		);
	}

	public function get(Campaign $campaign)
	{
		/** @var User $user */
		$user = $campaign->users()->find(\Auth::id());

		return [
			'campaign' => $campaign->load('quests', 'quests.steps', 'quests.comments', 'quests.comments.user', 'quests.comments.resource'),
			'user' => [
				'id' => $user->id,
				'isDM' => $user->pivot->is_dm,
			],
		];
	}
}
