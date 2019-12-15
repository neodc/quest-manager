<?php

namespace App\Http\Requests;

class EditStep extends FormRequest
{
	public function rules()
	{
		return [
            'name' => 'required|string|max:191',
            'player_content' => 'required|string',
            'dm_content' => 'nullable|string',
		];
	}
}
