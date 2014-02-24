<?php

namespace Imhonet\CacheProf\I;


use Imhonet\Connection\Request;

interface Storage
{
    /**
     * @param array $data [key => value, ...]
     * @param int $expire
     * @return Request
     */
    public function save(array $data, $expire = 0);

    /**
     * @param string[] $keys
     * @return Request
     */
    public function pick(array $keys);
}
