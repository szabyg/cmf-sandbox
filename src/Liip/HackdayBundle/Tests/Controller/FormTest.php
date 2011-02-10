<?php
namespace Liip\HackdayBundle\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/admin/');

        $this->assertTrue($crawler->filter('html:contains("Welcome to the Admin!")')->count() > 0);
    }
}