<?php

namespace App\Actions\Comment;

use App\Events\CommentAddedEvent;
use App\Models\ActivityLog;
use App\Models\Comment;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;

class StoreCommentAction
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function execute(array $validated)
    {
        $comment = Comment::create([
            'task_id' => $validated["task_id"],
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ])->fresh('user', 'task.users');

        $this->activityLogService->log('created', 'Comment', $comment->id);

        event(new CommentAddedEvent($comment));

        return response()->json($comment);
    }
}
