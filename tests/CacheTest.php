<?php

namespace MaartenGDev\Tests;

use MaartenGDev\Cache;
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
}