<?php

namespace App\Tests\Responses;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogoutPageResponseTest extends WebTestCase
{
    public function test_logoutPageResponse_success(): void
    {
        $client = static::createClient();
        $client->request('GET', '/logout');
        $client->request('GET', '/panel');

        $this->assertResponseRedirects('/login');
    }
}
