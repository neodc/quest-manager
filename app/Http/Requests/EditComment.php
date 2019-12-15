<?php

namespace App\Http\Requests;

class EditComment extends FormRequest
{
	public function rules()
	{
		return [
            'resource_id' => 'nullable|int|min:1',
            'player_text' => 'required|string',
            'dm_text' => 'nullable|string',
		];
	}
}
