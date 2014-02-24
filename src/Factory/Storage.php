<?php

namespace Imhonet\CacheProf\Factory;


use Imhonet\CacheProf\Model\Storage\Memcache;
use Imhonet\CacheProf\Model\Storage\Memcached;

class Storage
{
    /**
     * @return \Imhonet\CacheProf\I\Storage
     */
    public static function getDefault()
    {
        switch (\CACHE_STORAGE_DEFAULT) {
            case \CACHE_STORAGE_MEMCACHE:
                $result = self::getMemcache();
                break;
            default:
            case \CACHE_STORAGE_MEMCACHED:
                $result = self::getMemcached();
                break;
        }

        return $result;
    }

    public static function getMemcache()
    {
        return new Memcache();
    }

    public static function getMemcached()
    {
        return new Memcached();
    }
}