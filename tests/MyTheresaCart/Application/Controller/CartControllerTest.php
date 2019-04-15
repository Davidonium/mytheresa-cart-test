<?php


namespace App\Tests\MyTheresaCart\Application\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testListReturnsOK()
    {
        $client  = static::createClient();
        $client->request('GET', '/cart');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}