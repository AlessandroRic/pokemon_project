<?php

namespace App\Tests\Cache;

use App\Cache\RedisCacheService;
use PHPUnit\Framework\TestCase;

/**
 * Class RedisCacheServiceTest
 * 
 * This class contains unit tests for the RedisCacheService class.
 */
class RedisCacheServiceTest extends TestCase
{
    /**
     * Test case for setCache() and getCache() methods.
     * 
     * This test verifies that the setCache() and getCache() methods of the RedisCacheService class
     * work correctly by setting a cache value and then retrieving it.
     */
    public function testSetAndGetCache()
    {
        $cacheService = new RedisCacheService();
        $cacheService->setCache('test_key', 'test_value');
        $this->assertEquals('test_value', $cacheService->getCache('test_key'));
    }
}
