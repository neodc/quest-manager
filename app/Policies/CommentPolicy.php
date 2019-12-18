<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Comment $comment): bool
    {
		$questPolicy = new QuestPolicy();

		return $questPolicy->view($user, $comment->quest);
    }

    public function update(User $user, Comment $comment): bool
    {
		$questPolicy = new QuestPolicy();

		return $comment->user_id === $user->getKey() || $questPolicy->update($user, $comment->quest);
    }
}
