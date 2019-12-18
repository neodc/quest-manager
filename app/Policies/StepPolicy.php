<?php

namespace App\Policies;

use App\Models\Step;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StepPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Step $step): bool
    {
		$questPolicy = new QuestPolicy();

		return $questPolicy->view($user, $step->quest);
    }

    public function update(User $user, Step $step): bool
    {
		$questPolicy = new QuestPolicy();

		return $questPolicy->update($user, $step->quest);
    }
}
