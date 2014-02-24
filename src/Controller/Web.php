<?php

namespace Imhonet\CacheProf\Controller;


use Imhonet\CacheProf\Action\Action;
use Imhonet\CacheProf\Model\Context;

class Web
{
    /**
     * @var Action
     */
    private $action;

    public function setAction(Action $action)
    {
        $this->action = $action;
        $this->action->setContext($this->getContext());

        return $this;
    }

    private function getContext()
    {
        $context = new Context\Action();

        foreach ($_GET as $param => $value) {
            $context->setParam($param, $value);
        }

        return $context;
    }

    public function run()
    {
        $action = $this->action;
        $action();
    }

}
