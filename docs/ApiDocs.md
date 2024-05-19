# Pokémon API Docs

## API Documentation

### 1. List all Pokémon cards

**Endpoint:** `GET /api/cards`

**Description:** This endpoint returns a list of all available Pokémon cards.

**Success Response:**
- **Status:** 200 OK
- **Response Format:** JSON
- **Example Response:**
    ```json
    {
            "data": [
                    {
                            "id": "xy7-54",
                            "name": "Pikachu",
                            "types": ["Electric"],
                            "images": {
                                    "small": "https://images.pokemontcg.io/xy7/54.png",
                                    "large": "https://images.pokemontcg.io/xy7/54_hires.png"
                            }
                            // ... more data
                    },
                    {
                            "id": "sm1-1",
                            "name": "Bulbasaur",
                            "types": ["Grass"],
                            "images": {
                                    "small": "https://images.pokemontcg.io/sm1/1.png",
                                    "large": "https://images.pokemontcg.io/sm1/1_hires.png"
                            }
                    }
                    // ... more cards
            ]
    }
    ```

### 1. Show only the specified Pokémon

**Endpoint:** `GET /api/cards/{id}`

**Description:** This endpoint returns the requested Pokémon if available.

**Success Response:**
- **Status:** 200 OK
- **Response Format:** JSON
- **Example Response:**
    ```json
    {
            "data": {
                            "id": "xy7-54",
                            "name": "Pikachu",
                            "types": ["Electric"],
                            "images": {
                                    "small": "https://images.pokemontcg.io/xy7/54.png",
                                    "large": "https://images.pokemontcg.io/xy7/54_hires.png"
                            }
                            // ... more data
                    }
    }
    ```
