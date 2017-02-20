<?php
namespace MaartenGDev;

use Closure;
use MaartenGDev\Exceptions\BadMethodCallException;
use MaartenGDev\Exceptions\CacheEntryNotFoundException;
use MaartenGDev\Exceptions\CacheFileNotFoundException;

class Cache implements CacheInterface
{
    /**
     * @var StorageDriverInterface
     */
    private $storage;
    /**
     * @var
     */
    private $expire;

    /**
     * Cache constructor.
     *
     * @param StorageDriverInterface $storage
     * @param $expire
     */
    public function __construct(StorageDriverInterface $storage, $expire)
    {
        $this->storage = $storage;
        $this->expire = $expire;
    }

    /**
     * Checks if a cache entry for the $key exists.
     * The callable will be called if the cache entry is valid and exist.
     *
     * @param $key
     * @param $callable
     * @param $expireTime
     * @return bool|mixed
     * @throws BadMethodCallException
     */
    public function has($key, Closure $callable = null, $expireTime = null)
    {
        $hasProvidedCallable = !is_null($callable);
        $hasProvidedExpireTime = !is_null($expireTime);

        if (!$this->storage->fileExists($key)) {
            return false;
        }

        $expireTime = $hasProvidedExpireTime ? $expireTime : $this->expire;

        $isValid = $this->isValid($key, $expireTime);

        if ($hasProvidedCallable && $isValid) {
            return call_user_func_array($callable, [$this]);
        }

        return $isValid;
    }

    /**
     * Checks if there is a cache item for the key and
     * the data gets returned if an entry exists.
     *
     * @param $key
     * @param null $expire
     * @return mixed
     * @throws CacheEntryNotFoundException
     */
    public function get($key, $expire = null)
    {
        $hasProvidedExpireTime = !is_null($expire);

        $expireTime = $hasProvidedExpireTime ? $expire : $this->expire;

        if (!$this->isValid($key, $expireTime)) {
            throw new CacheEntryNotFoundException('No cache entry found.');
        }

        return $this->storage->get($key);
    }

    /**
     * Save a file with a checksum of the key in the cache directory
     *
     * @param $key
     * @param $data
     * @return mixed
     */
    public function store($key, $data)
    {
        return $this->storage->save($key, $data);
    }

    /**
     * Checks if the creating time is after expireTime
     *
     * @param $key
     * @param $minutes
     * @return bool
     *
     * @throws CacheFileNotFoundException
     */
    public function isValid($key, $minutes)
    {
        $path = $this->storage->getPath($key);

        $expireTime = strtotime("-{$minutes}  minutes");

        if(!file_exists($path)){
            throw new CacheFileNotFoundException('Cache File not found.');
        }

        return filectime($path) >= $expireTime;
    }
}