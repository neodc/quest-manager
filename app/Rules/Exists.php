<?php

namespace App\Rules;

use Illuminate\Database\Eloquent\Model;

class Exists extends \Illuminate\Validation\Rules\Exists
{
	public function __construct(string $model, $column = null)
	{
		/** @var Model $model */
		$model = new $model;

		parent::__construct($model->getTable(), $column ?? $model->getKeyName());
	}
}
