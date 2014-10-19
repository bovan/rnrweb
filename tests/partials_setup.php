<?php

$app->get('/partial/timeform', function () use ($app) {
        return $app['twig']->render('timeform.html', array());
    });
