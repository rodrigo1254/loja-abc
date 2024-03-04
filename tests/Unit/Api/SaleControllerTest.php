<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleCancel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class SaleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar e autenticar o usuário de teste
        $user = User::factory()->create();
        $this->actingAs($user);
    }

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

        $response->assertStatus(500);
    }

    public function test_show_with_valid_id()
    {
        // Criar uma venda simulada no banco de dados
        $sale = Sale::factory()->create();

        // Envio de uma solicitação simulada para o método show
        $response = $this->getJson('/api/sales/' . $sale->id);

        // Verifica se a resposta é bem-sucedida (código de status 200)
        $response->assertStatus(200);

        // Verifica se os dados da venda são retornados corretamente
        $response->assertJson([
            'data' => [
                'sales_id' => $sale->id,
                // Incluir outros campos da venda conforme necessário
            ]
        ]);
    }

    public function test_show_with_invalid_id()
    {
        // Envio de uma solicitação simulada para o método show com um ID inválido
        $response = $this->getJson('/api/sales/999');

        // Verifica se a resposta é um erro de venda não encontrada (código de status 404)
        $response->assertStatus(404);
    }

    public function test_cancel_with_valid_data()
    {
        // Criar uma venda válida para teste
        $sale = Sale::factory()->create();

        // Dados de teste para cancelamento
        $requestData = [
            'reason' => 'Produto não disponível'
        ];

        // Envio de uma solicitação simulada para o método cancel
        $response = $this->putJson('/api/sales/' . $sale->id . '/cancel', $requestData);

        // Verificar se a resposta é bem-sucedida (código de status 200)
        $response->assertStatus(200);

        // Verificar se a venda foi cancelada no banco de dados
        $this->assertDatabaseHas('sales', [
            'id' => $sale->id,
            'status' => config('constants.status_reverse.CANCELADO')
        ]);

        // Verificar se o registro de cancelamento da venda foi criado no banco de dados
        $this->assertDatabaseHas('sale_cancels', [
            'sale_id' => $sale->id,
            'observation' => $requestData['reason']
        ]);
    }

    public function test_cancel_with_invalid_data()
    {
        // Criar uma venda válida para teste
        $sale = Sale::factory()->create();

        // Dados de teste inválidos para cancelamento
        $requestData = [];

        // Envio de uma solicitação simulada para o método cancel
        $response = $this->putJson('/api/sales/' . $sale->id . '/cancel', $requestData);

        // Verificar se a resposta é um erro de dados inválidos (código de status 422)
        $response->assertStatus(422);
    }

    public function test_cancel_non_existing_sale()
    {
        // ID inválido para uma venda não existente
        $nonExistingSaleId = 999;

        // Dados de teste para cancelamento
        $requestData = [
            'reason' => 'Produto não disponível'
        ];

        // Envio de uma solicitação simulada para o método cancel
        $response = $this->putJson('/api/sales/' . $nonExistingSaleId . '/cancel', $requestData);

        // Verificar se a resposta é um erro de venda não encontrada (código de status 404)
        $response->assertStatus(404);
    }

    public function test_cancel_with_exception()
    {
        // Forçar uma exceção
        $this->expectException(\Exception::class);

        // Criar uma venda válida para teste
        $sale = Sale::factory()->create();

        // Dados de teste para cancelamento
        $requestData = [
            'reason' => 'Produto não disponível'
        ];

        // Simular uma falha ao salvar o cancelamento da venda
        SaleCancel::shouldReceive('updateOrCreate')->andReturn(false);

        // Envio de uma solicitação simulada para o método cancel
        $response = $this->putJson('/api/sales/' . $sale->id . '/cancel', $requestData);

        // Verificar se a resposta é um erro interno do servidor (código de status 500)
        $response->assertStatus(500);
    }
}
