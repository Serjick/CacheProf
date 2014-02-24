<?php

namespace Imhonet\CacheProf\Action;


use Faker\Factory as Faker;
use Imhonet\CacheProf\Factory\Storage;
use Imhonet\CacheProf\Model\Generate\Fixtures;
use Imhonet\CacheProf\Model\Generate\Labels;

class FillUp extends Action
{
    public function __invoke()
    {
        $fixtures = new Fixtures(new Labels(), Faker::create());

        foreach ($fixtures as $fixture) {
            $fixture = $this->mergeFixture($fixture);
            $ts = microtime(true);
            $response = Storage::getDefault()->save($fixture, $this->getExpire());
            $time = microtime(true) - $ts;
            echo $response->getErrorCode() ? PHP_EOL : CLI_CARRIAGE_RETURN,
                json_encode($response->getValue()), "\t",
                $response->getCount(), "\t",
                $time
            ;
        }
    }

    private function mergeFixture(array $fixture)
    {
        return call_user_func_array('array_merge', $fixture);
    }

    private function getExpire()
    {
        return strtotime('tomorrow 6:00') - time();
    }

}
