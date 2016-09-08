<?php
namespace App;


interface CacheInterface
{
    public function get($file);
    public function store($file,$data);
    public function isValid($file,$expire);
}