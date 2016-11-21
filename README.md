[![Build Status](https://travis-ci.org/MaartenGDev/CacheDrivers.svg?branch=master)](https://travis-ci.org/MaartenGDev/CacheDrivers)
[![Coverage Status](https://coveralls.io/repos/github/MaartenGDev/CacheDrivers/badge.svg?branch=master)](https://coveralls.io/github/MaartenGDev/CacheDrivers?branch=master)
[![Total Downloads](https://poser.pugx.org/maartengdev/cache-drivers/downloads)](https://packagist.org/packages/maartengdev/cache-drivers)
[![Latest Stable Version](https://poser.pugx.org/maartengdev/cache-drivers/v/stable)](https://packagist.org/packages/maartengdev/cache-drivers)
[![License](https://poser.pugx.org/maartengdev/cache-drivers/license)](https://packagist.org/packages/maartengdev/cache-drivers)
# Cache Drivers
An easy to use php caching library.

## Usage
##### Basic Usage
```PHP
$dir = $_SERVER['DOCUMENT_ROOT'] .'/cache/';
$expireTime = 30;

$driver = new LocalDriver($dir);
$cache = new Cache($driver, $expireTime);

$key = 'HelloWorld';

// Check if cache entry exists
$cacheHasKey = $cache->has($key);

// Create new cache entry
$cache->store($key, 'Hello World Cache Drivers');

// Get cache entry
$cacheEntry = $cache->get($key);
// result: "Hello World Cache Drivers"
```
##### Check for cache entry with closure
```PHP
$dir = $_SERVER['DOCUMENT_ROOT'] .'/cache/';
$drive = new LocalDriver($dir);
$cache = new Cache($drive,30);

function myFunction(Cache $cache){
    $key = 'HelloWorld';

    $cacheEntry = $cache->has($key, function ($cache) use ($key) {
        return $cache->get($key);
    });

    if ($cacheEntry) {
        return $cacheEntry;
    }

    $cache->store($key, 'Hello World!');

    return $cache->get($key);
}
myFunction($cache);

// result: "Hello World!"
```

## Licence
MIT
