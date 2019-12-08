<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @property int $id
 * @property int $quest_id
 * @property string $name
 * @property string $player_content
 * @property string $dm_content
 * @property string $state
 * @property bool $is_visible
 * @property-read Collection|Comment[] $comments
 * @property-read Quest $quest
 */
class Step extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'player_content',
		'dm_content',
		'state',
		'is_visible',
	];

	protected $casts = [
		'is_visible' => 'boolean',
	];

	public function quest()
	{
		return $this->belongsTo(Quest::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}
}
