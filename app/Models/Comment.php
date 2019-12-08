<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @property int $id
 * @property int $quest_id
 * @property int|null $user_id
 * @property int|null $step_id
 * @property int|null $resource_id
 * @property string $player_text
 * @property string $dm_text
 * @property bool $is_visible
 * @property string $type
 * @property-read Quest $quest
 * @property-read Resource|null $resource
 * @property-read Step|null $step
 * @property-read User|null $user
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
