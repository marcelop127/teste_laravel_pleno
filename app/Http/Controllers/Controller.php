<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Retorna uma response com os dados e o código http.
     *
     * @param  array|object  $data
     * @param  int  $code
     * @return \Illuminate\Http\Response
     */
    protected function response($data, $code=200) {
        return response()->json($data, $code);
    }

    /**
     * Retorna uma mensagem de erro.
     *
     * @param  int  $type
     * @return string
     */
    protected function errorMessages($type=null) {
        $erro_msg = '';

        switch ($type) {
            case 'update': 
                $erro_msg = 'Não foi possível atualizar os dados.';
                break;
            case 'not_found': 
                $erro_msg = 'Objeto não encontrado!';
                break;
            default:
                $erro_msg = 'Ocorreu um erro inesperado. Tente novamente.';
                break;
        };

        return $erro_msg;
    }

    /**
     * Retorna um erro através de uma response
     *
     * @param  \Exception  $e
     * @param  int  $type
     * @param  int  $code
     * @return \Illuminate\Http\Response
     */
    protected function errorResponse($e, $type=null, $code=500) {
        $data = [
            'msg' => $this->errorMessages($type),
            'erro' => $e->getMessage(),
        ];

        return $this->response($data, $code);
    }
}
