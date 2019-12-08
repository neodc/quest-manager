<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
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
		'icon',
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
