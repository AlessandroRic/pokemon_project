<?php

namespace App\Tests\Controller;

use App\Cache\RedisCacheService;
use App\Service\PokemonService;
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

    /**
     * Test the details action with a very large ID.
     */
    public function testDetailsWithLargeId()
    {
        $client = static::createClient();
        $client->request('GET', '/api/cards/' . str_repeat('a', 255));
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * Test the details action when the Pokemon service throws an exception.
     */
    public function testDetailsWithException()
    {
        // Mock the PokemonService to throw an exception
        $pokemonService = $this->createMock(PokemonService::class);
        $pokemonService->method('getPokemonDetails')->willThrowException(new \Exception('Error retrieving data'));

        $client = static::createClient();
        $client->getContainer()->set('App\Service\PokemonService', $pokemonService);
        $client->request('GET', '/api/cards/hgss4-1');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(['error' => 'Error retrieving data'], json_decode($client->getResponse()->getContent(), true));
    }

    /**
     * Test the index action when the cache service throws an exception.
     */
    public function testIndexCacheServiceException()
    {
        // Mock the RedisCacheService to throw an exception
        $cacheService = $this->createMock(RedisCacheService::class);
        $cacheService->method('getCache')->willThrowException(new \Exception('Cache error'));

        $client = static::createClient();
        $client->getContainer()->set('App\Cache\RedisCacheService', $cacheService);
        $client->request('GET', '/api/cards');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(['error' => 'Cache error'], json_decode($client->getResponse()->getContent(), true));
    }

    /**
     * Test the details action with special characters in the ID.
     */
    public function testDetailsWithSpecialCharacters()
    {
        $client = static::createClient();
        $client->request('GET', '/api/cards/hgss4-!@#');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}