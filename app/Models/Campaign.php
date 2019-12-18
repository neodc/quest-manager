<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $invite_id
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

	protected static function boot()
	{
		parent::boot();

		self::creating(
			function(self $model)
			{
				$model->generateInviteId();
			}
		);
	}

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

	public function generateInviteId()
	{
		$this->invite_id = Str::random(8); // 64 value by char so 64^8 = 2^48 = 256T possibility

		return $this;
	}
}
