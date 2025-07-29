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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->string('email')->nullable();
            $table->date('data_nasc')->nullable();
            $table->string('rg')->nullable();
            $table->string('org_exp')->nullable();
            $table->string('contato_1')->nullable();
            $table->string('contato_2')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('referencia')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('comp_residence')->nullable();
            $table->string('selfie')->nullable();
            $table->string('comp_instalacao')->nullable();
            $table->string('uf')->nullable();
            $table->string('cidade')->nullable();
            $table->string('bairro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('forma_pagamento')->nullable();
            $table->string('outros_form_pag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
