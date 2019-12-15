<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditStep;
use App\Models\Step;

class StepController extends Controller
{
	public function edit(Step $step, EditStep $request)
	{
		$step->name = $request->name;
		$step->player_content = $request->player_content;
		$step->dm_content = $request->dm_content ?? '';

		$step->save();
	}
}
