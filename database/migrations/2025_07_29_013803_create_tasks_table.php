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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('campaign_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('name');
            $table->string('status', 50)->default('Raw');
            $table->date('start_date')->nullable();
            $table->enum('type_task', ['design', 'vídeo', 'filme', 'copy', '3D', 'site', 'planejamento', 'CRM', 'tráfego pago'])->nullable();
            $table->integer('number')->nullable();
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->date('due_date')->nullable();
            $table->string('priority', 50)->default('baixa');
            $table->string('file')->nullable();
            $table->timestamps();
            $table->boolean('archived')->default(false);
            $table->integer('order_position')->default(0);
            $table->longText('involved_users')->nullable();
            $table->unsignedInteger('timer_status')->default(0)->comment('0-stopped  1-running  2-paused');
            $table->timestamp('last_started')->nullable();
            $table->unsignedInteger('time_spent')->default(0)->comment('segundos acumulados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
