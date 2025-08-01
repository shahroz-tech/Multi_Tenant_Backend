<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public function log(string $actionType, string $targetType, int $targetId, int $userId = null): void
    {
        ActivityLog::create([
            'user_id' => $userId ?? auth()->id(),
            'action_type' => $actionType,
            'target_type' => $targetType,
            'target_id' => $targetId,
        ]);
    }
}
