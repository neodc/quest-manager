<?php

namespace App\Policies;

use App\Models\Quest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Quest $quest): bool
    {
		$campaignPolicy = new CampaignPolicy();

		return $campaignPolicy->view($user, $quest->campaign);
    }

    public function update(User $user, Quest $quest): bool
    {
		$campaignPolicy = new CampaignPolicy();

		return $campaignPolicy->update($user, $quest->campaign);
    }
}
