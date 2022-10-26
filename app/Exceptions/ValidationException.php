<?php

namespace App\Exceptions;


use \Exception;
use Illuminate\Http\JsonResponse;

/**
 * Representa uma exception para ser retornada nos erros de validação nas classes do namespace \App\Http\Validations
 */
class ValidationException extends Exception
{

    private $_response;

    /**
     * Instancia um novo objeto da classe ValidationException
     * 
     * @param \Illuminate\Http\JsonResponse $response
     * @param string $message
     * @param int $code
     * @param Exception $previus
     */
    public function __construct(JsonResponse $response, $message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->_response = $response; 
    }

    /**
     * Retorna a propriedade _response
     */
    public function getResponse() { 
        return $this->_response;
    }
}