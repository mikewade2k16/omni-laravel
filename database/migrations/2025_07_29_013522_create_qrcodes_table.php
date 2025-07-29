<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 64);
            $table->text('target_url');
            $table->integer('scan_count')->default(0);
            $table->dateTime('last_scanned_at')->nullable();
            $table->string('qr_image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrcodes');
    }
};
