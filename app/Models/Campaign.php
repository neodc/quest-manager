<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 */
class Campaign extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
	];

	public function users()
	{
		return $this->belongsToMany(User::class)
			->using(CampaignUser::class)
			->withPivot(['is_dm']);
	}

	public function quests()
	{
		return $this->hasMany(Quest::class);
	}

	public function resources()
	{
		return $this->hasMany(Resource::class);
	}
}
