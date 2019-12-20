<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuest;
use App\Http\Requests\EditQuest;
use App\Http\Requests\Visibility;
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
			'is_visible' => false,
			'campaign_id' => $request->get('campaign_id'),
		]);

		$campaignService->broadcastUpdate($campaign->id);
	}

	public function edit(Quest $quest, EditQuest $request, CampaignService $campaignService)
	{
		$this->authorize('update', $quest);

		$quest->name = $request->name;

		$quest->save();

		$campaignService->broadcastUpdate($quest->campaign_id);
	}

	public function delete(Quest $quest, CampaignService $campaignService)
	{
		$this->authorize('update', $quest);

		$quest->delete();

		$campaignService->broadcastUpdate($quest->campaign_id);
	}

	public function visibility(Quest $quest, Visibility $request, CampaignService $campaignService)
	{
		$this->authorize('update', $quest);

		$quest->is_visible = $request->is_visible;

		$quest->save();

		$campaignService->broadcastUpdate($quest->campaign_id);
	}
}
