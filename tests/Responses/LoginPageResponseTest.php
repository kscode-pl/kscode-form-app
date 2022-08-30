<?php

namespace App\Tests\Responses;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginPageResponseTest extends WebTestCase
{
    public function test_loginPageResponse_success(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Login');
    }
}
