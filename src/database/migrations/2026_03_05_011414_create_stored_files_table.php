<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('stored_files', function (Blueprint $table) {
            $table->id();

            $table->string('original_name');
            $table->string('path')->unique();

            $table->string('mime_type', 50);
            $table->unsignedBigInteger('size');

            $table->timestamp('expires_at')->index();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['expires_at', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stored_files');
    }
};
