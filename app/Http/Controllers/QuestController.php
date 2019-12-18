<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuest;
use App\Models\Campaign;
use App\Models\Quest;

class QuestController extends Controller
{
	public function add(AddQuest $request)
	{
		$campaign = Campaign::findOrFail($request->get('campaign_id'));

		$this->authorize('update', $campaign);

		Quest::forceCreate([
			'name' => $request->get('name'),
			'campaign_id' => $request->get('campaign_id'),
		]);
	}

	public function delete(Quest $quest)
	{
		$this->authorize('update', $quest);

		$quest->delete();
	}
}
