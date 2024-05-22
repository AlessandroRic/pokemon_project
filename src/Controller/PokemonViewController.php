<?php

namespace App\Controller;

use App\Cache\RedisCacheService;
use App\Service\PokemonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonViewController extends AbstractController
{
    private $pokemonService;
    private $cacheService;

    /**
     * PokemonViewController constructor.
     *
     * @param PokemonService $pokemonService The Pokemon service.
     * @param RedisCacheService $cacheService The Redis cache service.
     */
    public function __construct(PokemonService $pokemonService, RedisCacheService $cacheService)
    {
        $this->pokemonService = $pokemonService;
        $this->cacheService = $cacheService;
    }

    /**
     * Shows the Pokemon cards.
     *
     * @return Response The response object.
     *
     * @Route('/', name: 'pokemon_cards')
     */
    #[Route('/', name: 'pokemon_cards')]
    public function showCards(): Response
    {
        $cacheKey = 'pokemon_cards';
        $cachedData = $this->cacheService->getCache($cacheKey);
        if ($cachedData) {
            $cards = $cachedData;
        } else {
            $cards = $this->pokemonService->getAllPokemon();
            $this->cacheService->setCache($cacheKey, $cards, 3600);
        }

        return $this->render('pokemon/cards.html.twig', [
            'cards' => $cards,
        ]);
    }

    /**
     * Shows the details of a Pokemon card.
     *
     * @param string $id The ID of the Pokemon card.
     *
     * @return Response The response object.
     *
     * @Route('/{id}', name: 'pokemon_card_details')
     */
    #[Route('/{id}', name: 'pokemon_card_details')]
    public function showCardDetails(string $id): Response
    {
        $card = $this->pokemonService->getPokemonDetails($id);

        return $this->render('pokemon/card_details.html.twig', [
            'card' => $card,
        ]);
    }
}
