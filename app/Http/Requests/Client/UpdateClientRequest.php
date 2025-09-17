<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ajuste se necessário
    }

    public function rules()
    {
        return [
            'nome'              => 'sometimes|required|string|max:255',
            'cpf'               => 'sometimes|nullable|string|max:20',
            'email'             => 'sometimes|nullable|email|max:255',
            'data_nasc'         => 'sometimes|nullable|date',
            'rg'                => 'sometimes|nullable|string|max:20',
            'org_exp'           => 'sometimes|nullable|string|max:50',
            'contato_1'         => 'sometimes|nullable|string|max:20',
            'contato_2'         => 'sometimes|nullable|string|max:20',
            'endereco'          => 'sometimes|nullable|string|max:255',
            'cep'               => 'sometimes|nullable|string|max:20',
            'referencia'        => 'sometimes|nullable|string|max:255',
            'user_id'           => 'sometimes|nullable|integer|exists:users,id',
            'comp_residence'    => 'sometimes|nullable|string|max:255',
            'selfie'            => 'sometimes|nullable|string|max:255',
            'comp_instalacao'   => 'sometimes|nullable|string|max:255',
            'uf'                => 'sometimes|nullable|string|max:2',
            'cidade'            => 'sometimes|nullable|string|max:100',
            'bairro'            => 'sometimes|nullable|string|max:100',
            'numero'            => 'sometimes|nullable|string|max:10',
            'complemento'       => 'sometimes|nullable|string|max:100',
            'forma_pagamento'   => 'sometimes|nullable|string|max:50',
            'outros_form_pag'   => 'sometimes|nullable|string|max:255',
        ];
    }
}
