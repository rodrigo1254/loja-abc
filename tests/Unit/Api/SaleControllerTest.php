<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_a_sale_with_valid_data()
    {
        // Dados de teste
        $requestData = [
            'products' => [
                ['product_id' => 1, 'amount' => 2],
                ['product_id' => 2, 'amount' => 3]
            ]
        ];

        // Criação de produtos de teste
        $products = Product::factory()->count(2)->create();

        // Envio de uma solicitação simulada para o método store
        $response = $this->postJson('/api/sales', $requestData);

        // Verifica se a resposta é bem-sucedida (código de status 200)
        $response->assertStatus(200);

        // Verifica se o modelo Sale foi criado no banco de dados
        $this->assertDatabaseHas('sales', []);

        // Verifica se os produtos de venda correspondentes foram criados no banco de dados
        foreach ($requestData['products'] as $productData) {
            $this->assertDatabaseHas('sale_products', [
                'product_id' => $productData['product_id'],
                'amount' => $productData['amount']
            ]);
        }
    }

    // Adicione mais testes conforme necessário para cobrir outros cenários possíveis
}
