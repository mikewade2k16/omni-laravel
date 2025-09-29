<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 * schema="Client",
 * type="object",
 * title="Client",
 * properties={
 * @OA\Property(property="id", type="integer", description="ID do cliente"),
 * @OA\Property(property="nome", type="string", description="Nome completo do cliente"),
 * @OA\Property(property="email", type="string", format="email", description="Email do cliente"),
 * @OA\Property(property="cpf", type="string", description="CPF do cliente"),
 * @OA\Property(property="data_nasc", type="string", format="date", description="Data de nascimento (AAAA-MM-DD)"),
 * @OA\Property(property="contato_1", type="string", description="Telefone de contato principal"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário que cadastrou", example=1),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */

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
