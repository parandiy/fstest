<?php

namespace App\Services;

use App\Models\StoredFile;
use App\Events\FileDeleted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileDeletionService
{
    public function delete(StoredFile $file): void
    {
        DB::transaction(function () use ($file) {

            Storage::delete($file->path);

            $file->delete();

            event(new FileDeleted(
                $file->id,
                $file->original_name
            ));
        });
    }
}
