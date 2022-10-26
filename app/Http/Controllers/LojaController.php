<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationException;
use App\Http\Validations\LojaValidation;
use App\Models\Loja;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LojaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lojas = Loja::paginate(15);

        $retorno = $lojas;

        return $this->response($retorno);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {
            $validation = new LojaValidation($request->all(), $request->method());
            $validation->validate();

            $loja = new Loja();
            $loja->nome = $request->nome;
            $loja->email = $request->email;
            $loja->save();

            $retorno = [
                'msg' => 'Objeto salvo com sucesso',
                'loja' => $loja,
            ];
            
            return $this->response($retorno);
        } catch (ValidationException $e) {
            return $e->getResponse();
        } catch (QueryException $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $loja = Loja::with('produtos')->findOrFail($id);
            
            $retorno = ['loja' => $loja];
            
            return $this->response($retorno);
        } catch (ValidationException $e) {
            return $e->getResponse();
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse($e, 'not_found', 404);
        } catch (QueryException $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validation = new LojaValidation($request->all(), $request->method(), $id);
            $validation->validate();

            $loja = Loja::findOrFail($id);
            $loja->nome = $request->nome;
            $loja->email = $request->email;
            $loja->save();
            
            return $this->response(['msg' => 'Objeto salvo com sucesso']);
        } catch (ValidationException $e) {
            return $e->getResponse();
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse($e, 'not_found', 404);
        } catch (QueryException $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $loja = Loja::findOrFail($id);

            $loja->delete();
            
            return $this->response(['msg' => 'Objeto deletado com sucesso.']);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse($e, 'not_found', 404);
        } catch (QueryException $e) {
            return $this->errorResponse($e);
        }
    }
}
