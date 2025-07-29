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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->string('visibility', 16)->default('private');
            $table->boolean('agency_access')->default(true);
            $table->string('icon', 50)->nullable();
            $table->text('description')->nullable();
            $table->longText('schema_json');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
