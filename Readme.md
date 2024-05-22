# Pokémon Project

## Introduction

This project is a Symfony web application that consumes the Pokémon TCG API and displays Pokémon cards. The application has two main features:
1. List all Pokémon cards.
2. Display the details of a specific card.

## Clone the Repository
   ```sh
   git clone git@github.com:AlessandroRic/pokemon_project.git
   cd pokemon_project
   ```

## Docker Installation and Usage

### Requirements

- Docker
- Docker Compose

### Docker Installation Steps

- ### [Windows](/docs/WindowsReadme.md)

- ### [Linux](/docs/LinuxReadme.md)

### **Official Docker Sites:**

- ### [Docker](https://docs.docker.com/engine/install/)
- ### [Docker Compose](https://docs.docker.com/compose/install/)

## Folder and File Architecture
- ### [Architecture](/docs/Architecture.md)

## Running the Code

1. ### Build Containers
    - (Docker) compose v1 run:
    ```
    docker-compose up -d --build
    ```
    - (Docker) compose v2 run:
    ```
    docker compose up -d --build
    ```
    - Notes: you can check it using `docker-compose -v` or `docker compose version`

2. ### Install Libraries & setup to environment
```
docker exec -it symfony_app ./setup.sh
```

3. ### Run Tests
```
docker exec -it symfony_app ./vendor/bin/phpunit
```

3. ### Access the Site
- #### System home page with all cards
    - Access [LocalHost](http://localhost:8080/)
- #### Card page
    - Click on the card to see more details

4. ### System APIs
    - ### [API Docs](/docs/ApiDocs.md)
```