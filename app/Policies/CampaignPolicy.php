<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Campaign $campaign): bool
    {
		return $user
			->campaigns()
			->newPivotStatementForId($campaign->getKey())
			->exists();
    }

    public function update(User $user, Campaign $campaign): bool
    {
		return $user
			->campaigns()
			->newPivotStatementForId($campaign->getKey())
			->where('is_dm', true)
			->exists();
    }
}
