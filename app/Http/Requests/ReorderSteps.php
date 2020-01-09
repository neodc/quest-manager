<?php

namespace App\Http\Requests;

class ReorderSteps extends FormRequest
{
	public function rules()
	{
		return [
			'*' => 'int',
		];
	}
}
