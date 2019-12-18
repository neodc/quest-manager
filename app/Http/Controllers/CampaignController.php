<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCampaign;
use App\Http\Requests\InviteCampaign;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

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

	public function getEdit(Campaign $campaign)
	{
		// TODO only dm

		return view(
			'campaign.edit',
			[
				'needJs' => true,
				'campaign' => $campaign,
			]
		);
	}

	public function postEdit(Campaign $campaign, CreateCampaign $request)
	{
		// TODO only dm

		$campaign->name = $request->get('name');

		$campaign->save();
	}

	public function resetLink(Campaign $campaign)
	{
		// TODO only dm

		$campaign->generateInviteId();
		$campaign->save();

		// TODO add flash

		return redirect()->route('campaign.edit', $campaign);
	}

	public function removePlayer(Campaign $campaign, User $user)
	{
		// TODO only dm

		$campaign->users()->detach($user);

		return redirect()->route('campaign.edit', $campaign);
	}

	public function setDm(Campaign $campaign, User $user)
	{
		// TODO only dm

		$campaign->users()->syncWithoutDetaching([
			$user->id => ['is_dm' => true],
		]);

		return redirect()->route('campaign.edit', $campaign);
	}

	public function unsetDm(Campaign $campaign, User $user)
	{
		// TODO only dm

		$campaign->users()->syncWithoutDetaching([
			$user->id => ['is_dm' => false],
		]);

		return redirect()->route('campaign.edit', $campaign);
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

		$resourcesQuery = $campaign->resources();

		if( !$user->pivot->is_dm )
		{
			$resourcesQuery
				->whereHas(
					'command_by',
					function(Builder $query)
					{
						$query->whereKey(\Auth::id());
					}
				);
		}

		return [
			'campaign' => $campaign->load('quests', 'quests.steps', 'quests.comments', 'quests.comments.user', 'quests.comments.resource'),
			'user' => [
				'id' => $user->id,
				'isDM' => $user->pivot->is_dm,
			],
			'resources' => $resourcesQuery->get(),
		];
	}
}
