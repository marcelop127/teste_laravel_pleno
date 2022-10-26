<?php

namespace App\Http\Validations;

/**
 * Representa a validação para os campos da classe \app\Model\Produto
 */
class ProdutoValidation extends Validation
{
    
    protected function getRules() {
        $rules = [];

        return $rules;
    }

    protected function postRules() {
        $rules = [
            'loja_id' => 'required|integer|exists:lojas,id',
            'nome' => 'required|string|min:3|max:60',
            'valor' => 'required|integer|min:10|max:999999',
            'ativo' => 'required|boolean',
        ];

        return $rules;
    }

    protected function putRules() {
        $rules = [
            'loja_id' => 'required|integer|exists:lojas,id',
            'nome' => 'required|string|min:3|max:60',
            'valor' => 'required|integer|min:10|max:999999',
            'ativo' => 'required|boolean',
        ];

        return $rules;
    }

    protected function deleteRules() {
        $rules = [];

        return $rules;
    }


}