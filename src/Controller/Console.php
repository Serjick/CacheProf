<?php

namespace Imhonet\CacheProf\Controller;


use Imhonet\CacheProf\Action\Action;
use Imhonet\CacheProf\Model\Context;

class Console
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

        for ($i = 1; $i < $_SERVER['argc']; $i++) {
            $param = explode('=', $_SERVER['argv'][$i], 2);
            $name = $param[0];
            $value = isset($param[1]) ? $param[1] : null;

            if (substr($name, 0, 2) == '--') {
                $context->setParam(substr($name, 2), $value);
            } else {
                trigger_error(sprintf('CLI parameter "%1$s" ignored. Use "--%1$s..." format.', $name), E_USER_WARNING);
            }
        }

        return $context;
    }

    public function run()
    {
        $action = $this->action;
        $action();
    }

}
