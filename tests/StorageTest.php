<?php
namespace MaartenGDev\Tests;

use MaartenGDev\LocalDriver;
use PHPUnit_Framework_Error_Warning;
use PHPUnit_Framework_TestCase;

class StorageTest extends PHPUnit_Framework_TestCase
{
    public function test_storage_cache_item_in_invalid_directory()
    {
        $this->expectException(PHPUnit_Framework_Error_Warning::class);

        $dir = dirname(__FILE__) . '/../invalid_directory/';
        $localStorage = new LocalDriver($dir);

        $cacheItem = $localStorage->save('test_cache_in_invalid_directory', 'Hello World');
    }

    public function test_storage_cache_item_in_invalid_directory_returns_false()
    {
        $dir = dirname(__FILE__) . '/../invalid_directory/';
        $localStorage = new LocalDriver($dir);

        $cacheItem = @$localStorage->save('test_cache_in_invalid_directory', 'Hello World');

        $this->assertFalse($cacheItem);
    }
}