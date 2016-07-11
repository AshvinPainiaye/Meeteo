<?php

namespace Meeteo\MeeteoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ManageControllerTest extends WebTestCase
{
    public function testManage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Manage');
    }

}
