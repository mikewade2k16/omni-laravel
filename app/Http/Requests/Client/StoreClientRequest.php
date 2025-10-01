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
            'email'             => 'required|email|max:255',
            'data_nasc'         => 'required|date',
            'rg'                => 'required|string|max:20',
            'org_exp'           => 'nullable|string|max:50',
            'contato_1'         => 'required|string|max:20',
            'contato_2'         => 'nullable|string|max:20',
            'endereco'          => 'required|string|max:255',
            'cep'               => 'required|string|max:20',
            'referencia'        => 'nullable|string|max:255',
            'user_id'           => 'nullable|integer|exists:users,id',
            'comp_residence'    => 'nullable|string|max:255',
            'selfie'            => 'nullable|string|max:255',
            'comp_instalacao'   => 'nullable|string|max:255',
            'uf'                => 'required|string|max:2',
            'cidade'            => 'required|string|max:100',
            'bairro'            => 'required|string|max:100',
            'numero'            => 'required|string|max:10',
            'complemento'       => 'nullable|string|max:100',
            'forma_pagamento'   => 'nullable|string|max:50',
            'outros_form_pag'   => 'nullable|string|max:255',
        ];
    }
}
