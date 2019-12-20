<?php

namespace App\Http\Requests;

class Visibility extends FormRequest
{
	public function rules()
	{
		return [
			'is_visible' => 'required|bool',
		];
	}
}
