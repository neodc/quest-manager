<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStep;
use App\Http\Requests\EditStep;
use App\Http\Requests\ReorderSteps;
use App\Http\Requests\StateStep;
use App\Http\Requests\Visibility;
use App\Models\Quest;
use App\Models\Step;
use App\Services\CampaignService;
use Illuminate\Support\Collection;

class StepController extends Controller
{
	public function add(AddStep $request, CampaignService $campaignService)
	{
		$quest = Quest::findOrFail($request->get('quest_id'));

		$campaign = $quest->campaign;

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

	public function visibility(Step $step, Visibility $request, CampaignService $campaignService)
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

	public function reorder(ReorderSteps $request, CampaignService $campaignService)
	{
		$orders = collect($request->all());

		/** @var Step[]|Collection $steps */
		$steps = Step::findMany($orders->keys());

		if($steps->count() !== $orders->count())
		{
			abort(400);
		}

		\DB::beginTransaction();

		foreach ($steps as $step)
		{
			$this->authorize('update', $step);
			$step->order = $orders[ $step->id ];
			$step->save();
		}

		\DB::commit();

		$campaignService->broadcastUpdate($step->quest->campaign_id);
	}
}
