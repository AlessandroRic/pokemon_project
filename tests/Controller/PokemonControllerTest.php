<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PokemonControllerTest
 * @package App\Tests\Controller
 */
class PokemonControllerTest extends WebTestCase
{
    /**
     * Test the index action of the PokemonController.
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/api/cards');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Test the details action of the PokemonController.
     */
    public function testDetails()
    {
        $client = static::createClient();
        $client->request('GET', '/api/cards/hgss4-1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Test an invalid route in the PokemonController.
     */
    public function testInvalidRoute()
    {
        $client = static::createClient();
        $client->request('GET', '/api/invalid-route');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * Test an invalid card ID in the PokemonController.
     */
    public function testInvalidCardId()
    {
        $client = static::createClient();
        $client->request('GET', '/api/cards/invalid-id');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * Test the cached response in the PokemonController.
     */
    public function testCachedResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/api/cards');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/api/cards');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}