<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
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
