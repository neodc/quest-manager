<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property-read Collection|Quest[] $quests
 * @property-read Collection|Resource[] $resources
 * @property-read Collection|User[] $users
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
