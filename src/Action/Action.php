<?php

namespace Imhonet\CacheProf\Action;


use Imhonet\CacheProf\Model\Context\Action as Context;

abstract class Action
{
    private $context;

    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @return Context
     */
    protected function getContext()
    {
        return $this->context;
    }

    abstract public function __invoke();
}
