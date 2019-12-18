<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCampaign;
use App\Http\Requests\InviteCampaign;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
		$this->authorize('update', $campaign);

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
		$this->authorize('update', $campaign);

		$campaign->name = $request->get('name');

		$campaign->save();
	}

	public function resetLink(Campaign $campaign)
	{
		$this->authorize('update', $campaign);

		$campaign->generateInviteId();
		$campaign->save();

		// TODO add flash

		return redirect()->route('campaign.edit', $campaign);
	}

	public function removePlayer(Campaign $campaign, User $user)
	{
		$this->authorize('update', $campaign);

		$campaign->users()->detach($user);

		return redirect()->route('campaign.edit', $campaign);
	}

	public function setDm(Campaign $campaign, User $user)
	{
		$this->authorize('update', $campaign);

		$campaign->users()->syncWithoutDetaching([
			$user->id => ['is_dm' => true],
		]);

		return redirect()->route('campaign.edit', $campaign);
	}

	public function unsetDm(Campaign $campaign, User $user)
	{
		$this->authorize('update', $campaign);

		$campaign->users()->syncWithoutDetaching([
			$user->id => ['is_dm' => false],
		]);

		return redirect()->route('campaign.edit', $campaign);
	}

	public function play(Campaign $campaign)
	{
		$this->authorize('view', $campaign);

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
		$this->authorize('view', $campaign);

		/** @var User $user */
		$user = $campaign->users()->find(\Auth::id());
		$isDm = $user->pivot->is_dm;

		$resourcesQuery = $campaign->resources();

		$relations = ['quests', 'quests.steps', 'quests.comments', 'quests.comments.user', 'quests.comments.resource'];

		if(!$isDm)
		{
			$resourcesQuery
				->whereHas(
					'command_by',
					function(Builder $query)
					{
						$query->whereKey(\Auth::id());
					}
				);

			$relations = [
				'quests' => function(HasMany $query){
					$query
						->where('is_visible', true)
						->select(['id', 'campaign_id', 'name'])
					;
				},
				'quests.steps' => function(HasMany $query){
					$query
						->where('is_visible', true)
						->select(['id', 'quest_id', 'name', 'player_content', 'state'])
					;
				},
				'quests.comments' => function(HasMany $query){
					$query
						->where('is_visible', true)
						->select(['id', 'quest_id', 'step_id', 'user_id', 'resource_id', 'player_text', 'type', 'created_at'])
					;
				},
				'quests.comments.user' => function(BelongsTo $query){
					$query->select(['id', 'name']);
				},
				'quests.comments.resource' => function(BelongsTo $query){
					$query->select(['id', 'name']);
				},
			];
		}

		return [
			'campaign' => $campaign->load($relations)->only(['id', 'name', 'quests']),
			'user' => [
				'id' => $user->id,
				'name' => $user->name,
				'isDM' => $isDm,
			],
			'resources' => $resourcesQuery->get(),
		];
	}
}
