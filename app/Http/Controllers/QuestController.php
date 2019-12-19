<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuest;
use App\Models\Campaign;
use App\Models\Quest;
use App\Services\CampaignService;

class QuestController extends Controller
{
	public function add(AddQuest $request, CampaignService $campaignService)
	{
		$campaign = Campaign::findOrFail($request->get('campaign_id'));

		$this->authorize('update', $campaign);

		Quest::forceCreate([
			'name' => $request->get('name'),
			'campaign_id' => $request->get('campaign_id'),
		]);

		$campaignService->broadcastUpdate($campaign->id);
	}

	public function delete(Quest $quest, CampaignService $campaignService)
	{
		$this->authorize('update', $quest);

		$quest->delete();

		$campaignService->broadcastUpdate($quest->campaign_id);
	}
}
