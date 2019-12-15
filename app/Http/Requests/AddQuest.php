<?php

namespace App\Http\Requests;

use App\Models\Campaign;
use App\Rules\Exists;

class AddQuest extends FormRequest
{
	public function rules()
	{
		return [
            'name' => 'required|string|max:191',
			'campaign_id' => [
				'required',
				new Exists(Campaign::class),
			]
		];
	}
}
