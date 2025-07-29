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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('name');
            $table->enum('status', ['not_started', 'raw', 'started', 'in_progress', 'awaiting_approval', 'completed', 'postponed', 'canceled']);
            $table->string('type_project')->nullable();
            $table->string('link')->nullable();
            $table->text('goal')->nullable();
            $table->text('description')->nullable();
            $table->date('date_project')->nullable();
            $table->string('category')->nullable();
            $table->string('segment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
