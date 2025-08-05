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
            $query
//                ->where('target_type', 'Project')
                ->where('target_id', $projectId);
        }) ->where('user_id', auth()->id())
            ->get()->all();

        return response()->json($logs);
    }
}
