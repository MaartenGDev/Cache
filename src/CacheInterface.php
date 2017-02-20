<?php
namespace MaartenGDev;


use Closure;

interface CacheInterface
{
    public function has($key, Closure $callable);
    public function get($key);
    public function store($key,$data);
    public function isValid($key,$expire);
}