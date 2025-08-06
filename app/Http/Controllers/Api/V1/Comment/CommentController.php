<?php

namespace App\Http\Controllers\Api\V1\Comment;

use App\Actions\Comment\StoreCommentAction;
use App\Actions\Comment\DeleteCommentAction;
use App\Events\CommentAddedEvent;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Comment;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        return auth()->user()->comments()->with('user','task')->get();
    }

    public function store(Request $request, StoreCommentAction $storeComment)
    {
        $validated = $request->validate([
            "task_id" => "required|exists:tasks,id",
            'body' => 'required|string',
        ]);

        $storeComment->execute($validated);
        return response()->json(['message' => 'Comment created'], 201);
    }

    public function destroy(int $id, DeleteCommentAction $action)
    {
        $userId = auth()->id();

        $action->execute($id, $userId);

        return response()->json([
            'message' => 'Comment deleted successfully.'
        ]);
    }

    public function restore($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return response()->json(['message' => 'Comment restored successfully.']);
    }

}
