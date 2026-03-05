<?php

namespace App\Events;

class FileDeleted
{
    public function __construct(
        public readonly int $fileId,
        public readonly string $filename
    ) {}
}
