<?php

namespace App\Http\Requests;

use App\Models\Quest;
use App\Rules\Exists;

class AddStep extends FormRequest
{
	public function rules()
	{
		return [
            'name' => 'required|string|max:191',
            'player_content' => 'nullable|string',
            'dm_content' => 'nullable|string',
			'quest_id' => [
				'required',
				new Exists(Quest::class),
			]
		];
	}
}
