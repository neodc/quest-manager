<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Exists;

class EditResource extends FormRequest
{
	public function rules()
	{
		return [
            'name' => 'required|string|max:191',
            'player_description' => 'nullable|string',
            'dm_description' => 'nullable|string',
			'command_by' => 'nullable|array',
			'command_by.*' => [
				'int',
				new Exists(User::class),
			],
		];
	}
}
