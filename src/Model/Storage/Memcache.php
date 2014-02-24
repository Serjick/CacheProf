<?php

namespace Imhonet\CacheProf\Model\Storage;


use Imhonet\CacheProf\I\Storage;
use Imhonet\Connection\DataFormat;
use Imhonet\Connection\Query;
use Imhonet\Connection\Request;
use Imhonet\Connection\Resource;

class Memcache implements Storage
{
    private $resource;

    private function getResourceDefault()
    {
        return $this->resource ? : $this->resource = Resource\Factory::getInstance()
            ->setHost(MMC_HOST)
            ->setPort(MMC_PORT)
            ->getResource(Resource\Factory::TYPE_MEMCACHE)
        ;
    }

    public function save(array $data, $expire = 0)
    {
        $query = new Query\Memcache\Set();
        $query->setResource($this->getResourceDefault());
        $query->setData($data);
        $query->setExpire($expire);

        $formater = new DataFormat\Bool\Memcache\Set();

        return (new Request($query, $formater))->execute();
    }

    public function pick(array $keys)
    {
        $query = new Query\Memcache\Get();
        $query->setResource($this->getResourceDefault());
        $query->setKeys($keys);

        $formater = new DataFormat\Arr\Memcache\Get();

        return (new Request($query, $formater))->execute();
    }

}
