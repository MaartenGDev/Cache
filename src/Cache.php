<?php
namespace MaartenGDev;


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
     * @return bool|mixed
     */
    public function has($key, $callable = null)
    {
        $isCallable = $callable !== null;


        if($isCallable && !is_callable($callable)){
            return false;
        }

        if (!$this->storage->fileExists($key)) {
            return false;
        }

        $isValid = $this->isValid($key, $this->expire);

        if ($isCallable && $isValid) {
            return call_user_func_array($callable, [$this]);
        }

        return $isValid;
    }

    /**
     * Checks if there is a cache item for the key and
     * the data gets returned if an entry exists.
     *
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function get($key)
    {
        if (!$this->isValid($key, $this->expire)) {
            throw new \Exception('No Cache Entry found');
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
     * @param $expire
     * @return bool
     *
     * @throws CacheFileNotFoundException
     */
    public function isValid($key, $expire)
    {
        $path = $this->storage->getPath($key);

        $expireTime = strtotime('-' . $expire . ' minutes');

        if(!file_exists($path)){
            throw new CacheFileNotFoundException('Cache File not found.');
        }

        return filectime($path) >= $expireTime;
    }
}