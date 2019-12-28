<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddResource;
use App\Http\Requests\EditResource;
use App\Http\Requests\Visibility;
use App\Models\Campaign;
use App\Models\Resource;
use App\Services\CampaignService;

class ResourceController extends Controller
{
	public function add(AddResource $request, CampaignService $campaignService)
	{
		$campaign = Campaign::findOrFail($request->get('campaign_id'));

		$this->authorize('update', $campaign);

		Resource::forceCreate([
			'name' => $request->get('name'),
			'is_visible' => false,
			'campaign_id' => $request->get('campaign_id'),

			'player_description' => '',
			'dm_description' => '',
		]);

		$campaignService->broadcastUpdate($campaign->id);
	}

	public function edit(Resource $resource, EditResource $request, CampaignService $campaignService)
	{
		$this->authorize('update', $resource);

		$resource->name = $request->name;
		$resource->player_description = $request->get('player_description', '');
		$resource->dm_description= $request->get('dm_description', '');

		$resource->save();

		$resource->command_by()->sync($request->get('command_by', []));

		$campaignService->broadcastUpdate($resource->campaign_id);
	}

	public function delete(Resource $resource, CampaignService $campaignService)
	{
		$this->authorize('update', $resource);

		$resource->delete();

		$campaignService->broadcastUpdate($resource->campaign_id);
	}

	public function visibility(Resource $resource, Visibility $request, CampaignService $campaignService)
	{
		$this->authorize('update', $resource);

		$resource->is_visible = $request->get('is_visible');

		$resource->save();

		$campaignService->broadcastUpdate($resource->campaign_id);
	}
}
