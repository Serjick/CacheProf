<?php

namespace Imhonet\CacheProf\Action;


use Faker\Factory as Faker;
use Imhonet\CacheProf\Factory\Storage;
use Imhonet\CacheProf\Model\Generate\Labels;

class GetProf extends Action
{
    private $start_time;

    public function __invoke()
    {
        $this->start_time = microtime(true);
        $keys = new Labels();
        $keys->rewind();

        for ($i = $this->getLimit(); $i > 0; $i--) {
            $keys_multi = array('label' => array(), 'stale' => array(), 'tags' => array());

            do {
                $keys_multi = array_merge_recursive($keys_multi, $keys->current());
                $keys->next();
            } while (mt_rand(0, 15));

            $labels = array_merge($keys_multi['label'], $keys_multi['stale']);
            $tags = $keys_multi['tags'];

            $ts = microtime(true);
            $response = Storage::getDefault()->pick($labels);
            $error = $response->getErrorCode();
            $labels_time = microtime(true) - $ts;
            $labels_count = $response->getCount();

            $ts = microtime(true);
            $response = Storage::getDefault()->pick($tags);
            $error = $error ? $response->getErrorCode() : $error;
            $tags_time = microtime(true) - $ts;
            $tags_count = $response->getCount();

            echo $error ? PHP_EOL : CLI_CARRIAGE_RETURN,
                'labels', "\t",
                $labels_count, "\t",
                $labels_time, "\t\t",
                'tags', "\t",
                $tags_count, "\t",
                $tags_time
            ;

            $this->getABrake($i);
        }
    }

    private function getLimit()
    {
        return mt_rand($this->getContext()->getParam('min', 1), $this->getContext()->getParam('max', mt_getrandmax()));
    }

    private function getABrake($i)
    {
        $limit_us = $this->getContext()->getParam('limit_ms') * 1000;
        $working_us = (microtime(true) - $this->start_time) * 1000 * 1000;
        $us = ($limit_us - $working_us) / $i;

        if ($us > 0) {
            usleep($us);
        }
    }

}
