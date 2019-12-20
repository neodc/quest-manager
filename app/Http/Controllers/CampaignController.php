<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCampaign;
use App\Http\Requests\InviteCampaign;
use App\Models\Campaign;
use App\Models\User;
use App\Services\CampaignService;

class CampaignController extends Controller
{
    public function list()
	{
		return view(
			'campaign.list',
			[
				'campaigns' => \Auth::user()->campaigns,
			]
		);
	}

    public function getCreate()
	{
		return view('campaign.create');
	}

    public function postCreate(CreateCampaign $request)
	{
		\Auth::user()->campaigns()->create(
			['name' => $request->get('name')],
			['is_dm' => true]
		);

		return redirect()->route('campaign.list');
	}

	public function getEdit(Campaign $campaign)
	{
		$this->authorize('update', $campaign);

		return view(
			'campaign.edit',
			[
				'needJs' => true,
				'campaign' => $campaign,
			]
		);
	}

	public function postEdit(Campaign $campaign, CreateCampaign $request)
	{
		$this->authorize('update', $campaign);

		$campaign->name = $request->get('name');

		$campaign->save();

		return redirect()
			->route('campaign.edit', $campaign)
			->with('status', trans('campaign.edit.success'));
	}

	public function resetLink(Campaign $campaign)
	{
		$this->authorize('update', $campaign);

		$campaign->generateInviteId();
		$campaign->save();

		return redirect()
			->route('campaign.edit', $campaign)
			->with('status', trans('campaign.edit.invite.success'));
	}

	public function removePlayer(Campaign $campaign, User $user)
	{
		$this->authorize('update', $campaign);

		$campaign->users()->detach($user);

		return redirect()->route('campaign.edit', $campaign);
	}

	public function setDm(Campaign $campaign, User $user)
	{
		$this->authorize('update', $campaign);

		$campaign->users()->syncWithoutDetaching([
			$user->id => ['is_dm' => true],
		]);

		return redirect()->route('campaign.edit', $campaign);
	}

	public function unsetDm(Campaign $campaign, User $user)
	{
		$this->authorize('update', $campaign);

		$campaign->users()->syncWithoutDetaching([
			$user->id => ['is_dm' => false],
		]);

		return redirect()->route('campaign.edit', $campaign);
	}

	public function play(Campaign $campaign)
	{
		$this->authorize('view', $campaign);

		$isDm = $campaign->users()->newPivotStatementForId(\Auth::id())->where('is_dm', true)->exists();

		return view(
			'campaign.play',
			[
				'needJs' => true,
				'campaign' => $campaign,
				'channel' => 'campaign-' . ($isDm ? 'dm' : 'player') . '.' . $campaign->id,
			]
		);
	}

	public function get(Campaign $campaign, CampaignService $campaignDataService)
	{
		$this->authorize('view', $campaign);

		return $campaignDataService->getDataToClientForUser($campaign, \Auth::user());
	}
}
