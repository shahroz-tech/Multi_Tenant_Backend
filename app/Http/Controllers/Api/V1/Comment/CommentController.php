<?php

namespace App\Http\Controllers\Api\V1\Comment;

use App\Actions\Comment\CreateCommentAction;
use App\Events\CommentAddedEvent;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::with('user', 'task')->get();
    }

    public function store(Request $request, CreateCommentAction $storeComment)
    {
        $validated = $request->validate([
            "task_id" => "required|exists:tasks,id",
            'body' => 'required|string',
        ]);

        $storeComment->execute($validated);

        return response()->json(['message' => 'Comment created'], 201);
    }

    public function restore($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return response()->json(['message' => 'Comment restored successfully.']);
    }

}
