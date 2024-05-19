<?php

namespace App\Entity;

class Pokemon
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $types;

    /**
     * @var array
     */
    private $images;

    /**
     * @var array
     */
    private $resistances;

    /**
     * @var array
     */
    private $weaknesses;

    /**
     * @var array
     */
    private $attacks;

    /**
     * Pokemon constructor.
     *
     * @param string $id
     * @param string $name
     * @param array $types
     * @param array $images
     * @param array $resistances
     * @param array $weaknesses
     * @param array $attacks
     */
    public function __construct(
        string $id,
        string $name,
        array $types,
        array $images,
        array $resistances = [],
        array $weaknesses = [],
        array $attacks = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->types = $types;
        $this->images = $images;
        $this->resistances = $resistances;
        $this->weaknesses = $weaknesses;
        $this->attacks = $attacks;
    }

    /**
     * Get the ID of the Pokemon.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the name of the Pokemon.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the types of the Pokemon.
     *
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * Get the images of the Pokemon.
     *
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * Get the resistances of the Pokemon.
     *
     * @return array
     */
    public function getResistances(): array
    {
        return $this->resistances;
    }

    /**
     * Get the weaknesses of the Pokemon.
     *
     * @return array
     */
    public function getWeaknesses(): array
    {
        return $this->weaknesses;
    }

    /**
     * Get the attacks of the Pokemon.
     *
     * @return array
     */
    public function getAttacks(): array
    {
        return $this->attacks;
    }

    /**
     * Convert the Pokemon object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'types' => $this->types,
            'images' => $this->images,
            'resistances' => $this->resistances,
            'weaknesses' => $this->weaknesses,
            'attacks' => $this->attacks,
        ];
    }
}
