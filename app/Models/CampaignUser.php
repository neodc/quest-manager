<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin \Eloquent
 * @property int $campaign_id
 * @property int $user_id
 * @property bool $is_dm
 */
class CampaignUser extends Pivot
{
	protected $casts = [
		'is_dm' => 'boolean',
	];
}
