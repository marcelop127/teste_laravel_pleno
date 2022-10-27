<?php

namespace App\Mail;

use App\Models\Produto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProdutoSaved extends Mailable
{
    use Queueable, SerializesModels;

    public $produto;
    public $assunto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Produto $produto, $assunto="NOVO PRODUTO CADASTRADO")
    {
        $this->produto = $produto;
        $this->assunto = $assunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dados = [
            'nome_produto' => $this->produto->nome,
            'valor_produto' => $this->produto->valor,
            'ativo_produto' => $this->produto->ativo,
        ];

        return $this->subject($this->assunto)
            ->markdown('mails.produtos.saved', $dados);
    }
}
