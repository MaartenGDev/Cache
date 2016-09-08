<?php
namespace App;


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
     * @param StorageDriverInterface $storage
     * @param $expire
     */
    public function __construct(StorageDriverInterface $storage, $expire)
    {
        $this->storage = $storage;
        $this->expire = $expire;
    }

    public function has($key, $callable)
    {

        if (!$this->storage->fileExists($key)) {
            return false;
        }
        $isValid = $this->isValid($key, $this->expire);

        if ($isValid) {
            return call_user_func_array($callable, [$this]);
        }
        return false;
    }

    public function get($key)
    {
        if (!$this->isValid($key, $this->expire)) {
            throw new \Exception('No Cache Entry found');
        }

        return $this->storage->get($key);
    }

    public function store($key, $data)
    {
        return $this->storage->save($key, $data);
    }


    public function isValid($file, $expire)
    {
        $file = $this->storage->getPath($file);

        $expireTime = strtotime('-' . $expire . ' minutes');

        return filectime($file) >= $expireTime;
    }
}