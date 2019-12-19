<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Models\Campaign;
use App\Models\User;

Broadcast::channel('campaign-player.{campaign}', function (User $user, Campaign $campaign) {
    return $campaign->users()->newPivotStatementForId($user->getKey())->exists();
});
Broadcast::channel('campaign-dm.{campaign}', function (User $user, Campaign $campaign) {
    return $campaign->users()->newPivotStatementForId($user->getKey())->where('is_dm', true)->exists();
});
