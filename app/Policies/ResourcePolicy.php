<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Resource $resource): bool
    {
		$campaignPolicy = new CampaignPolicy();

		return $campaignPolicy->view($user, $resource->campaign);
    }

    public function update(User $user, Resource $resource): bool
    {
		$campaignPolicy = new CampaignPolicy();

		return $campaignPolicy->update($user, $resource->campaign);
    }
}
