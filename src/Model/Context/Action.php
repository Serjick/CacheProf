<?php

namespace Imhonet\CacheProf\Model\Context;


class Action
{
    private $params = array();

    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function getParam($name, $default = null)
    {
        return array_key_exists($name, $this->params) ? $this->params[$name] : $default;
    }

}
