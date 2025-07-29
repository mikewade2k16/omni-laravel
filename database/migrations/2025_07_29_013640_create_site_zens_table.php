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
        Schema::create('site_zens', function (Blueprint $table) {
            $table->id();
            $table->string('mes', 7);
            $table->integer('visitas');
            $table->integer('compras');
            $table->integer('novas_visitas');
            $table->float('taxa_conversao');
            $table->float('ticket_medio');
            $table->float('pa')->nullable();
            $table->string('receita_total', 155);
            $table->longText('produtos_mais_vistos');
            $table->longText('produtos_comprados');
            $table->longText('funil_usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_zens');
    }
};
