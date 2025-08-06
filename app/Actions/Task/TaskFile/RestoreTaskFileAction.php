<?php

namespace App\Actions\Task\TaskFile;

use App\Models\File;
use App\Models\Task;

class RestoreTaskFileAction
{
    public function execute(int $fileId): File
    {
        $file = File::onlyTrashed()->findOrFail($fileId);
        $file->restore();

        return $file;
    }
}
