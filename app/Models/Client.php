<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;


    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'data_nasc',
        'rg',
        'org_exp',
        'contato_1',
        'contato_2',
        'endereco',
        'cep',
        'referencia',
        'user_id',
        'comp_residence',
        'selfie',
        'comp_instalacao',
        'uf',
        'cidade',
        'bairro',
        'numero',
        'complemento',
        'forma_pagamento',
        'outros_form_pag',
    ];

    protected $casts = [
        'data_nasc' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
