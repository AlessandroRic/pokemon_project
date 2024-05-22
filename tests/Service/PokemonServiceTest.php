<?php

namespace App\Tests\Service;

use App\Service\PokemonService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PokemonServiceTest extends TestCase
{
    /**
     * Test case for the getAllPokemon method of the PokemonService class.
     *
     * This method tests the functionality of the getAllPokemon method by mocking the HttpClientInterface
     * and the ResponseInterface. It asserts that the method returns the expected result.
     */
    public function testGetAllPokemon()
    {
        // Mocking the ResponseInterface
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn([
            'data' => [
                [
                    'id' => 'base1-1',
                    'name' => 'Alakazam',
                    'types' => ['Psychic'],
                    'images' => ['small' => 'small_url', 'large' => 'large_url'],
                    'resistances' => [],
                    'weaknesses' => [],
                    'attacks' => []
                ],
                [
                    'id' => 'base1-2',
                    'name' => 'Blastoise',
                    'types' => ['Water'],
                    'images' => ['small' => 'small_url', 'large' => 'large_url'],
                    'resistances' => [],
                    'weaknesses' => [],
                    'attacks' => []
                ]
            ]
        ]);

        // Mocking the HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('request')->with('GET', 'https://api.pokemontcg.io/v2/cards')->willReturn($response);

        // Instantiate the PokemonService with the mocked HttpClientInterface
        $pokemonService = new PokemonService($httpClient);

        // Assert the result
        $expectedResult = [
            [
                'id' => 'base1-1',
                'name' => 'Alakazam',
                'types' => ['Psychic'],
                'images' => ['small' => 'small_url', 'large' => 'large_url'],
                'resistances' => [],
                'weaknesses' => [],
                'attacks' => []
            ],
            [
                'id' => 'base1-2',
                'name' => 'Blastoise',
                'types' => ['Water'],
                'images' => ['small' => 'small_url', 'large' => 'large_url'],
                'resistances' => [],
                'weaknesses' => [],
                'attacks' => []
            ]
        ];

        $this->assertSame($expectedResult, $pokemonService->getAllPokemon());
    }

    /**
     * Test case for the getPokemonDetails method of the PokemonService class.
     *
     * This method tests the functionality of the getPokemonDetails method by mocking the HttpClientInterface
     * and the ResponseInterface. It asserts that the method returns the expected result.
     */
    public function testGetPokemonDetails()
    {
        // Mocking the ResponseInterface
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('toArray')->willReturn([
            'data' => [
                'id' => 'xy7-54',
                'name' => 'Gardevoir',
                'types' => ['Psychic'],
                'images' => ['small' => 'small_url', 'large' => 'large_url'],
                'resistances' => [],
                'weaknesses' => [],
                'attacks' => []
            ]
        ]);

        // Mocking the HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('request')->with('GET', 'https://api.pokemontcg.io/v2/cards/xy7-54')->willReturn($response);

        // Instantiate the PokemonService with the mocked HttpClientInterface
        $pokemonService = new PokemonService($httpClient);

        // Assert the result
        $expectedResult = [
            'id' => 'xy7-54',
            'name' => 'Gardevoir',
            'types' => ['Psychic'],
            'images' => ['small' => 'small_url', 'large' => 'large_url'],
            'resistances' => [],
            'weaknesses' => [],
            'attacks' => []
        ];

        $this->assertSame($expectedResult, $pokemonService->getPokemonDetails('xy7-54')->toArray());
    }

    /**
     * Test case for the getPokemonDetails method of the PokemonService class when the Pokemon is not found.
     *
     * This method tests the functionality of the getPokemonDetails method when the requested Pokemon is not found.
     * It mocks the HttpClientInterface and the ResponseInterface to simulate a 404 response. It asserts that the
     * method returns null.
     */
    public function testGetPokemonDetailsNotFound()
    {
        // Mocking the ResponseInterface for not found case
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(404);

        // Mocking the HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('request')->with('GET', 'https://api.pokemontcg.io/v2/cards/nonexistent-id')->willReturn($response);

        // Instantiate the PokemonService with the mocked HttpClientInterface
        $pokemonService = new PokemonService($httpClient);

        // Assert the result is null for not found
        $this->assertSame(null, $pokemonService->getPokemonDetails('nonexistent-id'));
    }

    /**
     * Test case for the getAllPokemon method of the PokemonService class when the API returns an empty list.
     *
     * This method tests the functionality of the getAllPokemon method when the API returns an empty list.
     */
    public function testGetAllPokemonEmptyList()
    {
        // Mocking the ResponseInterface
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['data' => []]);

        // Mocking the HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('request')->with('GET', 'https://api.pokemontcg.io/v2/cards')->willReturn($response);

        // Instantiate the PokemonService with the mocked HttpClientInterface
        $pokemonService = new PokemonService($httpClient);

        // Assert the result is an empty array
        $this->assertSame([], $pokemonService->getAllPokemon());
    }

    /**
     * Test case for the getAllPokemon method of the PokemonService class with a large data set.
     *
     * This method tests the functionality of the getAllPokemon method with a large data set.
     */
    public function testGetAllPokemonLargeDataSet()
    {
        // Generating a large data set
        $largeDataSet = [];
        for ($i = 0; $i < 1000; $i++) {
            $largeDataSet[] = [
                'id' => "base1-{$i}",
                'name' => "Pokemon {$i}",
                'types' => ['Type'],
                'images' => ['small' => 'small_url', 'large' => 'large_url'],
                'resistances' => [],
                'weaknesses' => [],
                'attacks' => []
            ];
        }

        // Mocking the ResponseInterface
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['data' => $largeDataSet]);

        // Mocking the HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('request')->with('GET', 'https://api.pokemontcg.io/v2/cards')->willReturn($response);

        // Instantiate the PokemonService with the mocked HttpClientInterface
        $pokemonService = new PokemonService($httpClient);

        // Assert the result
        $result = $pokemonService->getAllPokemon();
        $this->assertCount(1000, $result);
        $this->assertSame($largeDataSet[0]['id'], $result[0]['id']);
        $this->assertSame($largeDataSet[999]['id'], $result[999]['id']);
    }
}

