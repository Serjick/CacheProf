<?php

namespace Imhonet\CacheProf\Factory;


use Imhonet\CacheProf\Controller\Console;
use Imhonet\CacheProf\Controller\Web;

class Controller
{
    public static function getAuto()
    {
        switch (\PHP_SAPI) {
            case 'cli':
                $result = self::getConsole();
                break;
            default:
                $result = self::getWeb();
        }

        return $result;
    }

    public static function getConsole()
    {
        return new Console();
    }

    public static function getWeb()
    {
        return new Web();
    }
}
