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
    public function test_store_with_valid_data()
    {
        // Dados de teste
        $requestData = [
            'products' => [
                ['product_id' => 1, 'amount' => 2],
                ['product_id' => 2, 'amount' => 3]
            ]
        ];

        // Mock de produto válido
        Product::factory()->create(['id' => 1]);
        Product::factory()->create(['id' => 2]);

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

    public function test_store_with_invalid_product()
    {
        // Dados de teste com um produto inválido
        $requestData = [
            'products' => [
                ['product_id' => 999, 'amount' => 2] // Product com ID inválido
            ]
        ];

        // Envio de uma solicitação simulada para o método store
        $response = $this->postJson('/api/sales', $requestData);

        // Verifica se a resposta é um erro de produto não encontrado (código de status 404)
        $response->assertStatus(404);
    }

    public function test_store_with_exception()
    {
        // Forçar uma exceção
        $this->expectException(\Exception::class);

        // Dados de teste
        $requestData = [
            'products' => [
                ['product_id' => 1, 'amount' => 2],
                ['product_id' => 2, 'amount' => 3]
            ]
        ];

        // Simulando a falha na criação do Sale
        Sale::shouldReceive('create')->andReturn(false);

        // Envio de uma solicitação simulada para o método store
        $response = $this->postJson('/api/sales', $requestData);
    }


}
