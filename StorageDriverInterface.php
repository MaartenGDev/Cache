<?php
namespace MaartenGDev;


interface StorageDriverInterface
{
    public function fileExists($key);
    public function save($key,$data);
    public function getPath($key);
    public function get($key);
}