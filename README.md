[![Build Status](https://travis-ci.org/MaartenGDev/CacheDrivers.svg?branch=master)](https://travis-ci.org/MaartenGDev/CacheDrivers)
[![Coverage Status](https://coveralls.io/repos/github/MaartenGDev/CacheDrivers/badge.svg?branch=master)](https://coveralls.io/github/MaartenGDev/CacheDrivers?branch=master)
# Cache Drivers
An easy to use php caching library.

## Usage
##### Basic Usage
```PHP
$key = 'HelloWorld';

// Check if cache entry exists
$cacheHasKey = $this->cache->has($key);

// Create new cache entry
$this->cache->store($key, 'Hello World Cache Drivers');

// Get cache entry
$cacheEntry = $this->cache->get($key);
// result: "Hello World Cache Driers"
```
##### Check for cache entry with closure
```PHP
function myFunction(){
    $key = 'HelloWorld';

    $cache = $this->cache->has($key, function ($cache) use ($key) {
        return $cache->get($key);
    });

    if ($cache) {
        return $cache;
    }

    $this->cache->store($key, 'Hello World!');

    return $this->cache->get($key);
}
```

## Licence
MIT
