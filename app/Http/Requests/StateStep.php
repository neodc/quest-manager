<?php

namespace App\Http\Requests;

class StateStep extends FormRequest
{
	public function rules()
	{
		return [
			'state' => 'required|in:todo,in_progress,done',
		];
	}
}
