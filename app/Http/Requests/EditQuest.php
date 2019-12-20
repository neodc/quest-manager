<?php

namespace App\Http\Requests;

class EditQuest extends FormRequest
{
	public function rules()
	{
		return [
            'name' => 'required|string|max:191',
		];
	}
}
