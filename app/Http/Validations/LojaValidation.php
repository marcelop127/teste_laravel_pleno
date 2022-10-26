<?php

namespace App\Http\Validations;

/**
 * Representa a validação para os campos da classe \app\Model\Loja
 */
class LojaValidation extends Validation
{
    
    protected function getRules() {
        $rules = [];

        return $rules;
    }

    protected function postRules() {
        $rules = [
            'nome' => 'required|string|min:3|max:40',
            'email' => 'required|email|unique:lojas,email',
        ];

        return $rules;
    }

    protected function putRules() {
        $rules = [
            'nome' => 'required|string|min:3|max:40',
            'email' => 'required|email|unique:lojas,email' . ($this->ignore_id ? ','.$this->ignore_id : ''),
        ];

        return $rules;
    }

    protected function deleteRules() {
        $rules = [];

        return $rules;
    }


}