<?php

namespace App\Listeners;

use App\Events\FileDeleted;
use App\Services\RabbitMQPublisher;

class SendDeletionNotification
{
    public function handle(FileDeleted $event)
    {
        app(RabbitMQPublisher::class)->publish([
            'file_id' => $event->fileId,
            'filename' => $event->filename,
            'email' => config('app.notification_email'),
            'deleted_at' => now(),
        ]);
    }
}
