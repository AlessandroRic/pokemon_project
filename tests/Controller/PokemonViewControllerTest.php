<?php

namespace App\Tests\Controller;

use App\Entity\Pokemon;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PokemonViewControllerTest extends WebTestCase
{
    private function mockServices(ContainerInterface $container, $cacheData = null, $serviceData = null, $exception = false)
    {
        $cacheService = $this->createMock(\App\Cache\RedisCacheService::class);
        $pokemonService = $this->createMock(\App\Service\PokemonService::class);

        $cacheService->method('getCache')->willReturn($cacheData);
        $cacheService->method('setCache')->willReturn(null);

        if ($exception) {
            $pokemonService->method('getAllPokemon')->willThrowException(new \Exception('Service error'));
            $pokemonService->method('getPokemonDetails')->willThrowException(new \Exception('Service error'));
        } else {
            $pokemonService->method('getAllPokemon')->willReturn($serviceData ?? []);
            if ($serviceData) {
                $pokemon = new Pokemon(
                    $serviceData[0]['id'],
                    $serviceData[0]['name'],
                    $serviceData[0]['types'],
                    $serviceData[0]['images'],
                    $serviceData[0]['resistances'],
                    $serviceData[0]['weaknesses'],
                    $serviceData[0]['attacks']
                );
                $pokemonService->method('getPokemonDetails')->willReturn($pokemon);
            } else {
                $pokemonService->method('getPokemonDetails')->willReturn(null);
            }
        }

        $container->set('App\Cache\RedisCacheService', $cacheService);
        $container->set('App\Service\PokemonService', $pokemonService);
    }

    /**
     * Test the showCards method when cache is available.
     */
    public function testShowCardsWithCache()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $cacheData = [
            [
                'id' => 'base1-1',
                'name' => 'Alakazam',
                'types' => ['Psychic'],
                'images' => ['small' => 'small_url', 'large' => 'large_url'],
                'resistances' => [],
                'weaknesses' => [],
                'attacks' => []
            ]
        ];

        $this->mockServices($container, $cacheData);

        $client->request('GET', '/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('.card p', 'Name: Alakazam');
    }

    /**
     * Test the showCards method when cache is not available.
     */
    public function testShowCardsWithoutCache()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $serviceData = [
            [
                'id' => 'base1-1',
                'name' => 'Alakazam',
                'types' => ['Psychic'],
                'images' => ['small' => 'small_url', 'large' => 'large_url'],
                'resistances' => [],
                'weaknesses' => [],
                'attacks' => []
            ]
        ];

        $this->mockServices($container, null, $serviceData);

        $client->request('GET', '/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('.card p', 'Name: Alakazam');
    }

    /**
     * Test the showCardDetails method with valid ID.
     */
    public function testShowCardDetailsValidId()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $serviceData = [
            [
                'id' => 'base1-1',
                'name' => 'Alakazam',
                'types' => ['Psychic'],
                'images' => ['small' => 'small_url', 'large' => 'large_url'],
                'resistances' => [],
                'weaknesses' => [],
                'attacks' => []
            ]
        ];

        $this->mockServices($container, null, $serviceData);

        $client->request('GET', '/base1-1');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Alakazam');
    }

    /**
     * Test the showCardDetails method with invalid ID.
     */
    public function testShowCardDetailsInvalidId()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $this->mockServices($container, null, null);

        $client->request('GET', '/invalid-id');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}

