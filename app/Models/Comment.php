<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 */
class Comment extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'player_text',
		'dm_text',
		'is_visible',
		'type',
	];

	protected $casts = [
		'is_visible' => 'boolean',
	];

	public function quest()
	{
		return $this->belongsTo(Quest::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function step()
	{
		return $this->belongsTo(Step::class);
	}

	public function resource()
	{
		return $this->belongsTo(Resource::class);
	}
}
