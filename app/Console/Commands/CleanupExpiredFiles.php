<?php

namespace App\Console\Commands;

use App\Models\StoredFile;
use App\Services\FileDeletionService;
use Illuminate\Console\Command;

class CleanupExpiredFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-expired-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        FileDeletionService $service
    ) {
        StoredFile::whereNull('deleted_at')
            ->where('expires_at', '<=', now())
            ->chunkById(100, function ($files) use ($service) {

                foreach ($files as $file) {
                    $service->delete($file);
                }
            });
    }
}
