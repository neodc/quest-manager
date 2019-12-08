<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
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
		return $this->belongsToMany(User::class);
	}
}
