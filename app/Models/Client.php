<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 * schema="Client",
 * type="object",
 * title="Client",
 * description="Modelo de Cliente",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do cliente"),
 * @OA\Property(property="nome", type="string", description="Nome completo do cliente", example="João da Silva"),
 * @OA\Property(property="cpf", type="string", description="CPF do cliente", example="123.456.789-00"),
 * @OA\Property(property="email", type="string", format="email", description="Email do cliente", example="joao.silva@example.com"),
 * @OA\Property(property="data_nasc", type="string", format="date", description="Data de nascimento (AAAA-MM-DD)", example="1990-01-15"),
 * @OA\Property(property="rg", type="string", description="RG do cliente", example="1234567"),
 * @OA\Property(property="org_exp", type="string", description="Órgão expedidor do RG", example="SSP/SP"),
 * @OA\Property(property="contato_1", type="string", description="Telefone de contato principal", example="(11) 99999-8888"),
 * @OA\Property(property="contato_2", type="string", nullable=true, description="Telefone de contato secundário", example="(11) 98888-7777"),
 * @OA\Property(property="endereco", type="string", description="Endereço (nome da rua, avenida, etc.)", example="Rua das Flores"),
 * @OA\Property(property="cep", type="string", description="Código de Endereçamento Postal (CEP)", example="01234-567"),
 * @OA\Property(property="referencia", type="string", nullable=true, description="Ponto de referência do endereço", example="Próximo ao mercado"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário que cadastrou o cliente", example=1),
 * @OA\Property(property="comp_residence", type="string", nullable=true, description="Comprovante de residência (URL ou nome do arquivo)"),
 * @OA\Property(property="selfie", type="string", nullable=true, description="Selfie do cliente (URL ou nome do arquivo)"),
 * @OA\Property(property="comp_instalacao", type="string", nullable=true, description="Comprovante do local de instalação (URL ou nome do arquivo)"),
 * @OA\Property(property="uf", type="string", description="Unidade Federativa (Estado)", example="SP"),
 * @OA\Property(property="cidade", type="string", description="Cidade do endereço", example="São Paulo"),
 * @OA\Property(property="bairro", type="string", description="Bairro do endereço", example="Centro"),
 * @OA\Property(property="numero", type="string", description="Número do endereço", example="123"),
 * @OA\Property(property="complemento", type="string", nullable=true, description="Complemento do endereço", example="Apto 101"),
 * @OA\Property(property="forma_pagamento", type="string", description="Forma de pagamento", example="Boleto"),
 * @OA\Property(property="outros_form_pag", type="string", nullable=true, description="Descrição para outras formas de pagamento"),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
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
