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
        $response->method('toArray')->willReturn(['data' => ['card1', 'card2']]);

        // Mocking the HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('request')->with('GET', 'https://api.pokemontcg.io/v2/cards')->willReturn($response);

        // Instantiate the PokemonService with the mocked HttpClientInterface
        $pokemonService = new PokemonService($httpClient);

        // Assert the result
        $this->assertSame(['card1', 'card2'], $pokemonService->getAllPokemon());
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
        $response->method('toArray')->willReturn(['data' => ['id' => 'xy7-54', 'name' => 'Pikachu']]);

        // Mocking the HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('request')->with('GET', 'https://api.pokemontcg.io/v2/cards/xy7-54')->willReturn($response);

        // Instantiate the PokemonService with the mocked HttpClientInterface
        $pokemonService = new PokemonService($httpClient);

        // Assert the result
        $this->assertSame(['id' => 'xy7-54', 'name' => 'Pikachu'], $pokemonService->getPokemonDetails('xy7-54'));
    }

    /**
     * Test case for the getPokemonDetails method of the PokemonService class when the Pokemon is not found.
     *
     * This method tests the functionality of the getPokemonDetails method when the requested Pokemon is not found.
     * It mocks the HttpClientInterface and the ResponseInterface to simulate a 404 response. It asserts that the
     * method returns an empty array.
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

        // Assert the result is an empty array for not found
        $this->assertSame([], $pokemonService->getPokemonDetails('nonexistent-id'));
    }
}
