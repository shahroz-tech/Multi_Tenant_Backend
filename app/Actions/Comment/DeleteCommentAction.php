<?php

namespace App\Actions\Comment;

use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteCommentAction
{
    public function execute(int $commentId, int $userId): bool
    {
        $comment = Comment::findOrFail($commentId);

        // Optionally authorize the action
        if ($comment->user_id !== $userId) {
            throw new AuthorizationException('You are not allowed to delete this comment.');
        }

        return $comment->delete();
    }
}
