<?php

require_once __DIR__ .'/../vendor/autoload.php';
$app = require __DIR__ .'/../src/app.php';
require __DIR__.'/../config/prod.php';
// disable twig cache
$app['twig.options'] = array('cache' => false);
require __DIR__.'/../src/controllers.php';


return $app;