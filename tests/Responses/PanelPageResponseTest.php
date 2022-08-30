<?php

namespace App\Tests\Responses;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PanelPageResponseTest extends WebTestCase
{
    public function test_panelPageResponse_unauthorized(): void
    {
        $client = static::createClient();
        $client->request('GET', '/panel');

        $this->assertResponseRedirects('/login');
    }
}
