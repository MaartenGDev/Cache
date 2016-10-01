<?php

namespace MaartenGDev\Tests;

use MaartenGDev\Cache;
use MaartenGDev\Exceptions\BadMethodCallException;
use MaartenGDev\Exceptions\CacheEntryNotFound;
use MaartenGDev\Exceptions\CacheFileNotFoundException;
use MaartenGDev\LocalDriver;
use PHPUnit_Framework_TestCase;

class CacheTest extends PHPUnit_Framework_TestCase
{
    protected $dir;
    protected $localStorage;
    protected $cache;

    public function setUp(){
        $this->dir = dirname(__FILE__)  . '/../cache/';

        $this->localStorage = new LocalDriver($this->dir);

        $this->cache = new Cache($this->localStorage,5);

    }
    public function testCacheDoesNotHaveItem(){
        $keyNotFound = $this->cache->has('doesNotExist');

        $this->assertFalse($keyNotFound);
    }

    public function testCacheItemDoesExistAfterStoringIt(){
        $isStored = $this->cache->store('hello_world','Hello world!');

        $hasKey = $this->cache->has('hello_world');

        $this->assertTrue($hasKey);
    }

    public function testCacheIsValidWithInvalidItemGivesFileNotFoundException(){

        $this->expectException(CacheFileNotFoundException::class);

        $fileDoesNotExist = $this->cache->isValid('hello_world_invalid',5);
    }

    public function testCallHasItemInCacheWithInvalidClosure(){

        $stored = $this->cache->store('hello_world','Hello world!');

        $this->expectException(BadMethodCallException::class);
        $this->cache->has('hello_world','invalid closure');
    }

    public function testHasItemInCacheWithClosureReturnsClosureReturnValue(){

        $stored = $this->cache->store('hello_world','Hello world!');

        $hasItem = $this->cache->has('hello_world',function(){
            return 'correct';
        });

        $this->assertEquals('correct',$hasItem);
    }

    public function testGetCacheItemThatDoesNotExist(){

        $this->expectException(CacheFileNotFoundException::class);

        $this->cache->get('invalid_cache_item_name');
    }

    public function testGetCacheItemThatDoesExist(){
        $stored = $this->cache->store('cache_entry_name','New Entry Here');

        $cacheItem = $this->cache->get('cache_entry_name');

        $this->assertEquals($cacheItem,'New Entry Here');
    }

}