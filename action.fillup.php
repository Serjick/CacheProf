<?php

require __DIR__ . '/bootstrap.php';

\Imhonet\CacheProf\Factory\Controller::getAuto()->setAction(new \Imhonet\CacheProf\Action\FillUp())->run();
