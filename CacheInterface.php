<?php
namespace App;


interface CacheInterface
{
    public function has($key,$callable);
    public function get($key);
    public function store($key,$data);
    public function isValid($key,$expire);
}