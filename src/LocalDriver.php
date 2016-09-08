<?php
namespace MaartenGDev;


class LocalDriver implements StorageDriverInterface
{
    protected $dir = 'cache/';

    public function fileExists($key){
        return file_exists($this->dir . md5($key));
    }

    public function checksum($name){
        return md5($name);
    }

    public function save($key, $data)
    {
        $file = $this->checksum($key);

        if(file_put_contents($this->dir . $file, $data) !== false){
            return file_get_contents($this->dir . $file);
        }

        return false;
    }

    public function getPath($file)
    {
        return $this->dir . $this->checksum($file);
    }

    public function get($key)
    {
        $file = $this->checksum($key);

        return file_get_contents($this->dir . $file);
    }
}