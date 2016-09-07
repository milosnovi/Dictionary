<?php

namespace Dictionary\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->followRedirects();
        $client->request('GET', '/');

        $response =  $client->getResponse();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $crawler = new Crawler($response->getContent());
        $this->assertEquals(1, $crawler->filter('form')->count());
    }

    public function testIndexNoRedirect()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
