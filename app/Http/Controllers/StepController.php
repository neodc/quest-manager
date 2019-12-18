<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStep;
use App\Http\Requests\EditStep;
use App\Http\Requests\StateStep;
use App\Http\Requests\VisibilityStep;
use App\Models\Campaign;
use App\Models\Quest;
use App\Models\Step;
use Illuminate\Database\Eloquent\Builder;

class StepController extends Controller
{
	public function add(AddStep $request)
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
	}

	public function edit(Step $step, EditStep $request)
	{
		$this->authorize('update', $step);

		$step->name = $request->name;
		$step->player_content = $request->player_content;
		$step->dm_content = $request->dm_content ?? '';

		$step->save();
	}

	public function delete(Step $step)
	{
		$this->authorize('update', $step);

		$step->delete();
	}

	public function visibility(Step $step, VisibilityStep $request)
	{
		$this->authorize('update', $step);

		$step->is_visible = $request->is_visible;

		$step->save();
	}

	public function state(Step $step, StateStep $request)
	{
		$this->authorize('update', $step);

		$step->state = $request->state;

		$step->save();
	}
}
