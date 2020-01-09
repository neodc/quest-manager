<?php

namespace App\Services;

use App\Events\CampaignUpdated;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampaignService
{
	public function getDataToClientForUser(Campaign $campaign, User $user)
	{
		$isDm = (bool)$campaign->users()->newPivotStatementForId($user->getKey())->first()->is_dm;

		$data = $this->getDataToClient($campaign, $isDm);

		$data['user'] = [
			'id' => $user->id,
			'name' => $user->name,
			'isDM' => $isDm,
		];

		return $data;
	}

	public function getDataToClient(Campaign $campaign, bool $isDm)
	{
		$resourcesQuery = $campaign->resources()
			->with(
				[
					'command_by' => function (BelongsToMany $query) {
						$query->select(['id']);
					}
				]
			);

		$relations = [
			'quests',
			'quests.steps' => function(HasMany $query){
				$query->orderBy('order');
			},
			'quests.comments',
			'quests.comments.user',
			'quests.comments.resource',
		];

		if(!$isDm)
		{
			$resourcesQuery
				->select(['id', 'name', 'player_description'])
				->where('is_visible', true);

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
						->orderBy('order')
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

		$users = $campaign->users()
			->select(['id', 'name'])
			->get()
			->map(
				function(User $user)
				{
					$user->isDM = $user->pivot->is_dm;
					unset($user->pivot);

					return $user;
				}
			);

		return [
			'campaign' => $campaign->load($relations)->only(['id', 'name', 'quests']),
			'resources' => $resourcesQuery->get(),
			'users' => $users,
		];
	}

	public function broadcastUpdate(int $campaignId)
	{
		$campaign = Campaign::findOrFail($campaignId);

		event(new CampaignUpdated($this->getDataToClient($campaign, true), true));
		event(new CampaignUpdated($this->getDataToClient($campaign, false), false));
	}
}
