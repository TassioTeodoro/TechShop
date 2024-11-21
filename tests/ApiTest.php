<?php

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private $baseUrl;

    protected function setUp(): void
    {
        $this->baseUrl = 'http://localhost:8080/src/api';
    }

    public function testGetProdutos()
    {
        $url = $this->baseUrl . '/produtos';
        $response = $this->makeRequest('GET', $url);

        $this->assertEquals(200, $response['http_code'], "Falha ao acessar a rota GET /produtos");

        $produtos = json_decode($response['body'], true);
        $this->assertIsArray($produtos, "A resposta não é um JSON válido ou não é uma lista de produtos.");

        foreach ($produtos as $produto) {
            $this->assertArrayHasKey('id', $produto, "O produto não contém o campo 'id'.");
            $this->assertArrayHasKey('name', $produto, "O produto não contém o campo 'name'.");
            $this->assertArrayHasKey('descricao', $produto, "O produto não contém o campo 'descricao'.");
            $this->assertArrayHasKey('preco', $produto, "O produto não contém o campo 'preco'.");
            $this->assertArrayHasKey('quantidade', $produto, "O produto não contém o campo 'quantidade'.");
        }
    }

    public function testCreateProduto()
    {
        $url = $this->baseUrl . '/produtos';
        $payload = [
            'id' => '48',
            'name' => 'Teclado Gamer',
            'descricao' => 'Teclado mecânico RGB',
            'quantidade' => 10,
            'preco' => 150.00,
        ];

        $response = $this->makeRequest('POST', $url, json_encode($payload), [
            'Content-Type: application/json',
        ]);

        $this->assertEquals(201, $response['http_code'], "Falha ao acessar a rota POST /produtos");

        $produto = json_decode($response['body'], true);
        $this->assertArrayHasKey('id', $produto, "A resposta não contém o ID do produto criado.");
        $this->assertEquals($payload['name'], $produto['name'], "O name do produto não corresponde.");
        $this->assertEquals($payload['preco'], $produto['preco'], "O preço do produto não corresponde.");
    }

    public function testDeleteProduto()
    {
        $url = $this->baseUrl . '/produtos';
        $payload = [
            'name' => 'Mouse Gamer',
            'descricao' => 'Mouse óptico RGB',
            'quantidade' => 5,
            'preco' => 100.00,
        ];

        $response = $this->makeRequest('POST', $url, json_encode($payload), [
            'Content-Type: application/json',
        ]);

        $produto = json_decode($response['body'], true);
        $produtoId = $produto['id'];

        $url = $this->baseUrl . '/produtos';
        $response = $this->makeRequest('DELETE', $url, json_encode(['id' => $produtoId]), [
            'Content-Type: application/json',
        ]);

        $this->assertEquals(204, $response['http_code'], "Falha ao acessar a rota DELETE /produtos");
    }

    public function testCreatePedido()
    {
        $url = $this->baseUrl . '/pedidos';
        $payload = [
            'produto_id' => 1,
            'quantidade' => 2,
        ];

        $response = $this->makeRequest('POST', $url, json_encode($payload), [
            'Content-Type: application/json',
        ]);

        $this->assertEquals(201, $response['http_code'], "Falha ao acessar a rota POST /pedidos");

        $pedido = json_decode($response['body'], true);
        $this->assertArrayHasKey('id', $pedido, "A resposta não contém o ID do pedido criado.");
        $this->assertEquals($payload['produto_id'], $pedido['produto_id'], "O ID do produto no pedido não corresponde.");
        $this->assertEquals($payload['quantidade'], $pedido['quantidade'], "A quantidade do pedido não corresponde.");
    }

    public function testDeletePedido()
    {
        $url = $this->baseUrl . '/pedidos';
        $payload = [
            'produto_id' => 1,
            'quantidade' => 1,
        ];

        $response = $this->makeRequest('POST', $url, json_encode($payload), [
            'Content-Type: application/json',
        ]);

        $pedido = json_decode($response['body'], true);
        $pedidoId = $pedido['id'];

        $url = $this->baseUrl . '/pedidos';
        $response = $this->makeRequest('DELETE', $url, json_encode(['id' => $pedidoId]), [
            'Content-Type: application/json',
        ]);

        $this->assertEquals(204, $response['http_code'], "Falha ao acessar a rota DELETE /pedidos");
    }

    private function makeRequest($method, $url, $payload = null, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($payload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            throw new \RuntimeException('Erro ao realizar a requisição: ' . curl_error($ch));
        }

        curl_close($ch);

        return [
            'body' => $response,
            'http_code' => $httpCode,
        ];
    }
}
