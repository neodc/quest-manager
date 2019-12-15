<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStep;
use App\Http\Requests\EditStep;
use App\Http\Requests\StateStep;
use App\Http\Requests\VisibilityStep;
use App\Models\Step;

class StepController extends Controller
{
	public function add(AddStep $request)
	{
		Step::forceCreate([
			'name' => $request->get('name'),
			'player_content' => $request->get('player_content') ?? '',
			'dm_content' => $request->get('dm_content') ?? '',
			'quest_id' => $request->get('quest_id'),

			'is_visible' => false,
			'state' => 'todo',
		]);
	}

	public function edit(Step $step, EditStep $request)
	{
		$step->name = $request->name;
		$step->player_content = $request->player_content;
		$step->dm_content = $request->dm_content ?? '';

		$step->save();
	}

	public function delete(Step $step)
	{
		$step->delete();
	}

	public function visibility(Step $step, VisibilityStep $request)
	{
		$step->is_visible = $request->is_visible;

		$step->save();
	}

	public function state(Step $step, StateStep $request)
	{
		$step->state = $request->state;

		$step->save();
	}
}
