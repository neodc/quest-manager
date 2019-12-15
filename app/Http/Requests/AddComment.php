<?php

namespace App\Http\Requests;

use App\Models\Quest;
use App\Rules\Exists;

class AddComment extends FormRequest
{
	public function rules()
	{
		return [
            'resource_id' => 'nullable|int|min:1',
            'player_text' => 'nullable|string',
            'dm_text' => 'nullable|string',
			'quest_id' => [
				'required',
				new Exists(Quest::class),
			],
			'type' => 'nullable|in:message,event',
		];
	}
}
