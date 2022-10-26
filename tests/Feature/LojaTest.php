<?php

namespace Tests\Feature;

use App\Models\Loja;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LojaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // test create
        $loja = Loja::factory()->make();

        $fields = [
            'nome' => $loja->nome,
            'email' => $loja->email,
        ];

        $response = $this->post('/api/lojas', $fields);
        
        $response->assertStatus(200);

        $loja_array = json_decode($response->content());

        //test show
        $id = $loja_array->loja->id;        

        $response = $this->get('/api/lojas/'.$id);
        
        $response->assertStatus(200)
            ->assertJson([
                'loja'=> [
                    'id' => $id,
                    'nome' => $loja->nome,
                    'email' => $loja->email,
                ]
            ]);

        //test update
        $loja = Loja::factory()->make();
        
        $fields = [
            'nome' => $loja->nome,
            'email' => $loja->email,
        ];

        $response = $this->put('/api/lojas/'.$id, $fields);
        
        $response->assertStatus(200);

        //test delete
        $response = $this->delete('/api/lojas/'.$id);
        $response->assertStatus(200);
    }
}
