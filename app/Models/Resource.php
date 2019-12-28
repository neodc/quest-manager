<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @property int $id
 * @property int $campaign_id
 * @property string $name
 * @property string $player_description
 * @property string $dm_description
 * @property bool $is_visible
 * @property-read Campaign $campaign
 * @property-read Collection|User[] $command_by
 * @property-read Collection|Comment[] $comments
 */
class Resource extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'player_description',
		'dm_description',
		'is_visible',
	];

	protected $appends = [
		'player_description_html',
		'dm_description_html',
	];

	protected $casts = [
		'is_visible' => 'boolean',
	];

	public function campaign()
	{
		return $this->belongsTo(Campaign::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function command_by()
	{
		return $this->belongsToMany(User::class, 'user_can_talk_as_resource')->withTimestamps();
	}

	public function getPlayerDescriptionHtmlAttribute()
	{
		return \Parsedown::instance()->text($this->player_description);
	}

	public function getDmDescriptionHtmlAttribute()
	{
		if( $this->dm_description === null ){
			return null;
		}

		return \Parsedown::instance()->text($this->dm_description);
	}
}
