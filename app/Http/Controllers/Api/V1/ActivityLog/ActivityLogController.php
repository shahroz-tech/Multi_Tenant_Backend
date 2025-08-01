<?php

namespace App\Http\Controllers\Api\V1\ActivityLog;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index($projectId)
    {
        $logs = ActivityLog::where(function ($query) use ($projectId) {
            $query->where('target_type', 'Project')
                ->where('target_id', $projectId);
        })
//            ->orWhereIn('target_type', ['Task', 'Comment']) // optional if you want related
            ->latest()
            ->get();

        return response()->json($logs);
    }
}
