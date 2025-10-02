<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome'              => 'required|string|max:255',
            'cpf'               => 'required|string|max:20',
            'email'             => 'nullable|email|max:255',
            'data_nasc'         => 'nullable|date',
            'rg'                => 'nullable|string|max:20',
            'org_exp'           => 'nullable|string|max:50',
            'contato_1'         => 'nullable|string|max:20',
            'contato_2'         => 'nullable|string|max:20',
            'endereco'          => 'nullable|string|max:255',
            'cep'               => 'nullable|string|max:20',
            'referencia'        => 'nullable|string|max:255',
            'user_id'           => 'nullable|integer|exists:users,id',
            'comp_residence'    => 'nullable|string|max:255',
            'selfie'            => 'nullable|string|max:255',
            'comp_instalacao'   => 'nullable|string|max:255',
            'uf'                => 'nullable|string|max:2',
            'cidade'            => 'nullable|string|max:100',
            'bairro'            => 'nullable|string|max:100',
            'numero'            => 'nullable|string|max:10',
            'complemento'       => 'nullable|string|max:100',
            'forma_pagamento'   => 'nullable|string|max:50',
            'outros_form_pag'   => 'nullable|string|max:255',
        ];
    }
}
