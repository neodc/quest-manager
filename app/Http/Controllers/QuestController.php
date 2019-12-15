<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuest;
use App\Models\Quest;

class QuestController extends Controller
{
	public function add(AddQuest $request)
	{
		Quest::forceCreate([
			'name' => $request->get('name'),
			'campaign_id' => $request->get('campaign_id'),
		]);
	}

	public function delete(Quest $quest)
	{
		$quest->delete();
	}
}
