<?php

namespace App\Http\Requests;

class InviteCampaign extends FormRequest
{
	public function rules()
	{
		return [
            'email' => 'required|email|max:191',
		];
	}
}
