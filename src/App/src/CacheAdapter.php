<?php
declare(strict_types=1);


namespace App;


use Psr\SimpleCache\CacheInterface;

class CacheAdapter implements CacheInterface
{

    public function get($key, $default = null)
    {
        return null;
    }

    public function set($key, $value, $ttl = null)
    {
        return null;
    }

    public function delete($key)
    {
        return null;
    }

    public function clear()
    {
        return null;
    }

    public function getMultiple($keys, $default = null)
    {
        return null;
    }

    public function setMultiple($values, $ttl = null)
    {
        return null;
    }

    public function deleteMultiple($keys)
    {
        return null;
    }

    public function has($key)
    {
        return null;
    }
}