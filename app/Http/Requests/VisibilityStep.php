<?php

namespace App\Http\Requests;

class VisibilityStep extends FormRequest
{
	public function rules()
	{
		return [
			'is_visible' => 'required|bool',
		];
	}
}
