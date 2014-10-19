<?php

use Silex\Application;
use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;

class AppTest extends WebTestCase
{

    /**
     * Creates the application.
     *
     * @return HttpKernel
     */
    public function createApplication()
    {
        $app = new Application();
        require __DIR__ . '/../bootstrap.php';
        return $this->app = $app;
    }

    public function testInitialPage()
    {
        $client = $this->createClient();
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('DOCTYPE html', $client->getResponse()->getContent());
    }


    /**
     * @TODO: complete timeform thingy
     * form test example: 
     *   https://github.com/lyrixx/Silex-Kitchen-Edition/blob/master/tests/functional/ApplicationTest.php
     */
    public function testPartialTimeformPage()
    {
        $app = $this->app;

        $app->get('/test/timeform', function () use ($app) {
                return $app['twig']->render('timeform.html', array());
            });

        $client = $this->createClient();
        $client->request('GET', '/test/timeform');
        
        $this->assertTrue($client->getResponse()->isOk());
    
        $content = $client->getResponse()->getContent();
        $this->assertContains('form', $content);
    }

}