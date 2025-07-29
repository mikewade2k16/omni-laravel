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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('level', ['admin','manager','marketing','finance']);
            $table->integer('client_id')->nullable();
            $table->string('name');
            $table->string('nick', 50);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['active','inactive']);
            $table->string('phone', 20)->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamp('last_login')->useCurrent()->useCurrentOnUpdate();
            $table->enum('user_type', ['client','admin']);
            $table->text('preferences')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
