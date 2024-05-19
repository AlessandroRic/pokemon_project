<?php

namespace App\Controller;

use App\Cache\RedisCacheService;
use App\Service\PokemonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    private $pokemonService;
    private $cacheService;

    /**
     * PokemonController constructor.
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
     * Retrieves all Pokemon cards.
     *
     * @Route("/api/cards", name="pokemon_index", methods={"GET"})
     *
     * @return Response The HTTP response.
     */
    public function index(): Response
    {
        $cacheKey = 'pokemon_index';
        $cachedData = $this->cacheService->getCache($cacheKey);

        if ($cachedData) {
            return new JsonResponse($cachedData);
        }

        $response = $this->pokemonService->getAllPokemon();
        $this->cacheService->setCache($cacheKey, $response, 3600);

        return new JsonResponse(['data' => $response]);
    }

    /**
     * Retrieves details of a specific Pokemon card.
     *
     * @Route("/api/cards/{id}", name="pokemon_details", methods={"GET"})
     *
     * @param int $id The ID of the Pokemon card.
     * @return Response The HTTP response.
     */
    public function details($id): Response
    {
        $cacheKey = 'pokemon_details_' . $id;
        $cachedData = $this->cacheService->getCache($cacheKey);

        if ($cachedData) {
            return new JsonResponse($cachedData);
        }

        $response = $this->pokemonService->getPokemonDetails($id);

        if (!$response) {
            return new JsonResponse(['error' => 'Pokemon not found'], Response::HTTP_NOT_FOUND);
        }

        $this->cacheService->setCache($cacheKey, $response, 3600);

        return new JsonResponse($response);
    }
}
