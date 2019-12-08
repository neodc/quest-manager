<?php

namespace App\Http\Requests;

class CreateCampaign extends FormRequest
{
	public function rules()
	{
		return [
            'name' => 'required|string|max:191',
		];
	}
}
