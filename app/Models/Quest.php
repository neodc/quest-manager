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
 * @property bool $is_visible
 * @property-read Campaign $campaign
 * @property-read Collection|Comment[] $comments
 * @property-read Collection|Step[] $steps
 */
class Quest extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'is_visible',
	];

	protected $casts = [
		'is_visible' => 'boolean',
	];

	public function campaign()
	{
		return $this->belongsTo(Campaign::class);
	}

	public function steps()
	{
		return $this->hasMany(Step::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}
}
