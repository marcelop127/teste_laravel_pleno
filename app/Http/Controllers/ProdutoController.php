<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationException;
use App\Http\Validations\ProdutoValidation;
use App\Models\Produto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::paginate(15);

        $retorno = $produtos;

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
            $validation = new ProdutoValidation($request->all(), $request->method());
            $validation->validate();

            $produto = new Produto();
            $produto->loja_id =  $request->loja_id;
            $produto->nome =  $request->nome;
            $produto->valor =  $request->valor;
            $produto->ativo =  $request->ativo;
            $produto->save();

            $retorno = [
                'msg' => 'Objeto salvo com sucesso',
                'produto' => $produto,
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
            $produto = Produto::findOrFail($id);
            
            $retorno = ['produto' => $produto];
            
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
            $validation = new ProdutoValidation($request->all(), $request->method(), $id);
            $validation->validate();

            $produto = Produto::findOrFail($id);
            $produto->loja_id =  $request->loja_id;
            $produto->nome =  $request->nome;
            $produto->valor =  $request->valor;
            $produto->ativo =  $request->ativo;
            $produto->save();
            
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
            $produto = Produto::findOrFail($id);

            $produto->delete();
            
            return $this->response(['msg' => 'Objeto deletado com sucesso.']);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse($e, 'not_found', 404);
        } catch (QueryException $e) {
            return $this->errorResponse($e);
        }
    }
}
