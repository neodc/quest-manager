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
 * @property-read string $player_content_html
 * @property-read string $dm_content_html
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

	protected $appends = [
		'player_content_html',
		'dm_content_html',
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

	public function getPlayerContentHtmlAttribute()
	{
		return \Parsedown::instance()->text($this->player_content);
	}

	public function getDmContentHtmlAttribute()
	{
		return \Parsedown::instance()->text($this->dm_content);
	}
}
