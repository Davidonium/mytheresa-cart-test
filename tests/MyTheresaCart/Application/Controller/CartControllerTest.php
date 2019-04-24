<?php


namespace App\Tests\MyTheresaCart\Application\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testListReturnsOK()
    {
        $client  = static::createClient();
        $client->request('GET', '/cart/product', [], [], ['HTTP_AUTHORIZATION' => 'Bearer: randomgeneratedtoken']);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testListReturnsUnauthorized()
    {
        $client = static::createClient();
        $client->request('GET', '/cart/product');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testAddCartReturnsOK()
    {
        $client = static::createClient([], ['CONTENT_TYPE' => 'application/json']);
        $client->request(
            'PUT',
            '/cart/product/add',
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => 'Bearer: randomgeneratedtoken',
                'CONTENT_TYPE'       => 'application/json'
            ],
            json_encode(['productId' => 1])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testAddCartReturnsUnauthorized()
    {
        $client = static::createClient([], ['CONTENT_TYPE' => 'application/json']);
        $client->request(
            'PUT',
            '/cart/product/add',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json'
            ],
            json_encode(['productId' => 1])
        );

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testAddCartReturnsNotFoundOnNonExistingProduct()
    {
        $client = static::createClient([], ['CONTENT_TYPE' => 'application/json']);
        $client->request(
            'PUT',
            '/cart/product/add',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json'
            ],
            json_encode(['productId' => 123131231])
        );

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}