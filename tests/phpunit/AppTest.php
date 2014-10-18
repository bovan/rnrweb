<?php

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
        return require __DIR__ . '/../bootstrap.php';
    }

    public function testInitialPage()
    {
        $client = $this->createClient();
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('DOCTYPE html', $client->getResponse()->getContent());
    }
}