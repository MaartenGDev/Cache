<?php
namespace MaartenGDev;


class LocalDriver implements StorageDriverInterface
{
    protected $dir = '';

    /**
     * LocalDriver constructor.
     *
     * @param $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * Checks if a file exists with the correct checksum.
     *
     * @param $key
     * @return bool
     */
    public function fileExists($key){
        return file_exists($this->dir . $this->checksum($key));
    }

    /**
     * Creates a checksum using the $key of the cache entry to store.
     *
     * @param $name
     * @return string
     */
    public function checksum($name){
        return md5($name);
    }

    /**
     * Saves the cache entry to cache folder.
     * Returns false when the file could
     * not be created (for example incorrect permissions).
     *
     * @param $key
     * @param $data
     * @return bool|string
     */
    public function save($key, $data)
    {
        $file = $this->checksum($key);

        if(file_put_contents($this->dir . $file, $data) !== false){
            return file_get_contents($this->dir . $file);
        }

        return false;
    }

    /**
     * Returns the path with the cache save location.
     * @param $file
     * @return string
     */
    public function getPath($file)
    {
        return $this->dir . $this->checksum($file);
    }

    /**
     * Returns the content of a cache entry.
     * 
     * @param $key
     * @return string
     */
    public function get($key)
    {
        $file = $this->checksum($key);

        return file_get_contents($this->dir . $file);
    }
}