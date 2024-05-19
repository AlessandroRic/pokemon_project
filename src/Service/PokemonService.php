<?php

namespace App\Service;

use App\Entity\Pokemon;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PokemonService
{
    private $client;

    /**
     * PokemonService constructor.
     *
     * @param HttpClientInterface $client The HTTP client used to make requests.
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves all Pokemon cards from the API.
     *
     * @return array The array of Pokemon card data.
     */
    public function getAllPokemon(): array
    {
        $response = $this->client->request('GET', 'https://api.pokemontcg.io/v2/cards');
        $data = $response->toArray()['data'];

        $pokemons = [];
        foreach ($data as $item) {
            $pokemons[] = (new Pokemon(
                $item['id'],
                $item['name'],
                $item['types'] ?? [],
                $item['images'],
                $item['resistances'] ?? [],
                $item['weaknesses'] ?? [],
                $item['attacks'] ?? []
            ))->toArray();
        }

        return $pokemons;
    }

    /**
     * Retrieves details of a specific Pokemon card.
     *
     * @param string $id The ID of the Pokemon card.
     * @return array The array of Pokemon card details.
     */
    public function getPokemonDetails($id): ?Pokemon
    {
        $response = $this->client->request('GET', "https://api.pokemontcg.io/v2/cards/{$id}");
        if ($response->getStatusCode() === 200) {
            $data = $response->toArray()['data'];
            return (new Pokemon(
                $data['id'],
                $data['name'],
                $data['types'] ?? [],
                $data['images'],
                $data['resistances'] ?? [],
                $data['weaknesses'] ?? [],
                $data['attacks'] ?? []
            ))->toArray();
        } else {
            return null;
        }
    }
}
