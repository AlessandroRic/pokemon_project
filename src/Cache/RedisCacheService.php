<?php

namespace App\Cache;

use Predis\Client;

/**
 * Class RedisCacheService
 * 
 * Provides caching functionality using Redis as the cache store.
 */
class RedisCacheService
{
    /**
     * @var Client The Redis client instance.
     */
    private $client;

    /**
     * RedisCacheService constructor.
     * 
     * Initializes a new instance of the RedisCacheService class.
     */
    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => 'redis_cache',
            'port'   => 6379,
        ]);
    }

    /**
     * Sets a value in the cache with the specified key and time-to-live (TTL).
     * 
     * @param string $key The cache key.
     * @param mixed $value The value to be cached.
     * @param int $ttl The time-to-live (TTL) in seconds. Default is 3600 seconds (1 hour).
     * @return void
     */
    public function setCache(string $key, $value, $ttl = 3600)
    {
        $this->client->setex($key, $ttl, serialize($value));
    }

    /**
     * Retrieves a value from the cache with the specified key.
     * 
     * @param string $key The cache key.
     * @return mixed|null The cached value, or null if the key does not exist in the cache.
     */
    public function getCache(string $key)
    {
        $value = $this->client->get($key);
        return $value ? unserialize($value) : null;
    }

    /**
     * Clears the cache for the specified key.
     * 
     * @param string $key The cache key.
     * @return void
     */
    public function clearCache(string $key)
    {
        $this->client->del([$key]);
    }
}
