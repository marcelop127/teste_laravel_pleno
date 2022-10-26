<?php

namespace App\Http\Validations;

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

/**
 * Representa o modelo de validação para as suas especializações
 */
abstract class Validation
{
    protected $fields;
    protected $method;
    protected $ignore_id;
    protected $validator;

    /**
     * Instancia um objeto da classe Validation.
     *
     * @param  array  $fields
     * @param  string  $method
     * @param  int  $ignore_id
     */
    function __construct($fields, $method=null, $ignore_id=null) {
        $this->fields = $fields;
        $this->method = $method;
        $this->ignore_id = $ignore_id;
    }

    public function validate() {
        $this->validator = Validator::make($this->fields, $this->rules());

        if ($this->fails())
            throw new ValidationException($this->responseErrors(), 'Erro na validação');
    }

    public function fails() {
        return $this->validator->fails();
    }

    public function responseErrors() {
        $response = response()->json($this->validator->errors(), 422);

        return $response;
    }
    
    /**
     * Retorna as regras de validação.
     * 
     * @param string $method Pode ser especificado para ser usado ao invés do método especificado no construtor
     * @return array Se o parametro $method não foi definido no construtor, ou o seu valor não for encontrado nas regras, será retornado um array vazio
     */
    protected function rules($method=null) {
        $aux_method = $method ?? $this->method;

        $functions = [
            'GET'    => function () { return $this->getRules(); },
            'POST'   => function () { return $this->postRules(); },
            'PUT'    => function () { return $this->putRules(); },
            'DELETE' => function () { return $this->deleteRules(); },
        ];

        $rules = array_key_exists($aux_method, $functions) ? $functions[$aux_method]() : [];

        return $rules;
    }

    /**
     * Retorna os campos de validação para o método get.
     */
    abstract protected function getRules();

    /**
     * Retorna os campos de validação para o método post.
     */
    abstract protected function postRules();

    /**
     * Retorna os campos de validação para o método put.
     */
    abstract protected function putRules();

    /**
     * Retorna os campos de validação para o método delete.
     */
    abstract protected function deleteRules();
}