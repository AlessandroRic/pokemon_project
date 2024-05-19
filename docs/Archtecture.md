# Archtecture

```
pokemon-tcg-api/
├── config/
│   ├── packages/
│   │   └── cache.yaml
│   ├── routes.yaml
│   └── services.yaml
├── public/
│   ├── .htaccess
│   └── css/
│       └── styles.css
├── src/
│   ├── Controller/
│   │   ├── PokemonController.php
│   │   └── PokemonViewController.php
│   ├── Entity/
│   │   └── Pokemon.php
│   ├── Repository/
│   │   └── PokemonRepository.php
│   ├── Service/
│   │   └── PokemonService.php
│   ├── Cache/
│   │   └── RedisCacheService.php
│   └── Entitiy/
│       └── Pokemon.php
├── templates/
│   └── pokemon/
│       ├── card_details.html.twig
│       └── cards.html.twig
├── tests/
│   ├── Controller/
│   │   └── PokemonControllerTest.php
│   ├── Cache/
│   │   └── RedisCacheServiceTest.php
│   └── Service/
│       └── PokemonServiceTest.php
```