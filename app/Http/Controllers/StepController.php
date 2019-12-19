<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStep;
use App\Http\Requests\EditStep;
use App\Http\Requests\StateStep;
use App\Http\Requests\VisibilityStep;
use App\Models\Campaign;
use App\Models\Quest;
use App\Models\Step;
use App\Services\CampaignService;
use Illuminate\Database\Eloquent\Builder;

class StepController extends Controller
{
	public function add(AddStep $request, CampaignService $campaignService)
	{
		$campaign = Campaign::whereHas(
			'quests',
			function (Builder $query) use ($request) {
				$query->whereKey($request->get('quest_id'));
			}
		);

		$quest = Quest::findOrFail($request->get('quest_id'));

		$this->authorize('update', $quest);

		$quest->steps()
			->create(
				[
					'name' => $request->get('name'),
					'player_content' => $request->get('player_content') ?? '',
					'dm_content' => $request->get('dm_content') ?? '',

					'is_visible' => false,
					'state' => 'todo',
				]
			);

		$campaignService->broadcastUpdate($campaign->id);
	}

	public function edit(Step $step, EditStep $request, CampaignService $campaignService)
	{
		$this->authorize('update', $step);

		$step->name = $request->name;
		$step->player_content = $request->player_content;
		$step->dm_content = $request->dm_content ?? '';

		$step->save();

		$campaignService->broadcastUpdate($step->quest->campaign_id);
	}

	public function delete(Step $step, CampaignService $campaignService)
	{
		$this->authorize('update', $step);

		$step->delete();

		$campaignService->broadcastUpdate($step->quest->campaign_id);
	}

	public function visibility(Step $step, VisibilityStep $request, CampaignService $campaignService)
	{
		$this->authorize('update', $step);

		$step->is_visible = $request->is_visible;

		$step->save();

		$campaignService->broadcastUpdate($step->quest->campaign_id);
	}

	public function state(Step $step, StateStep $request, CampaignService $campaignService)
	{
		$this->authorize('update', $step);

		$step->state = $request->state;

		$step->save();

		$campaignService->broadcastUpdate($step->quest->campaign_id);
	}
}
