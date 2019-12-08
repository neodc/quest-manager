<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignUser extends Pivot
{
	protected $casts = [
		'is_dm' => 'boolean',
	];
}
