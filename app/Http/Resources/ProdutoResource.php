<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'loja_id' => $this->loja_id,
            'nome' => $this->nome,
            'valor' => 'R$ ' . number_format($this->valor / 100, 2, ',', ''),
            'ativo' => $this->ativo,
        ];
    }
}
