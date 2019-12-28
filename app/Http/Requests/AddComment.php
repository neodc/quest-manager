<?php

namespace App\Http\Requests;

use App\Models\Quest;
use App\Models\Resource;
use App\Models\Step;
use App\Rules\Exists;

class AddComment extends FormRequest
{
	public function rules()
	{
		return [
            'resource_id' => [
            	'nullable',
				'int',
				new Exists(Resource::class),
			],
            'step_id' => [
            	'nullable',
				'int',
				new Exists(Step::class),
			],
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
