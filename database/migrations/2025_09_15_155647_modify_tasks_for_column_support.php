<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Apenas adiciona a nova coluna (nullable para não dar erro ao criar tarefas)
            $table->foreignId('column_id')->nullable()->after('id')->constrained('columns')->onDelete('set null');

            // E remove a antiga
            $table->dropColumn('status');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['column_id']);
            $table->dropColumn('column_id');
            $table->string('status')->nullable()->after('id');
        });
    }
};