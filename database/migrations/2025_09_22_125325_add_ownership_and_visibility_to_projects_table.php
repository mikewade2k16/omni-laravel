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
        Schema::table('projects', function (Blueprint $table) {
            // Campo para saber quem criou o projeto
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->onDelete('set null');

            // Campo para definir se o projeto é público ou privado
            $table->string('visibility')->default('private')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
