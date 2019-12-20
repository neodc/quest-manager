<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InviteController extends Controller
{
	public function invite(string $inviteId)
	{
		$campaign = Campaign::where('invite_id', $inviteId)->firstOrFail();

		/** @var User $user */
		$user = \Auth::user();

		/** @var BelongsToMany $relation */
		$relation = $campaign->users();

		if(!$relation->whereKey($user->id)->exists())
		{
			$relation->attach($user, ['is_dm' => false]);
		}

		return redirect()
			->route('campaign.list')
			->with('status', trans('campaign.edit.invite.joined', ['name' => $campaign->name]));
	}
}
