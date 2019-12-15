<?php

namespace App\Http\Requests;

class VisibilityComment extends FormRequest
{
	public function rules()
	{
		return [
			'is_visible' => 'required|bool',
		];
	}
}
