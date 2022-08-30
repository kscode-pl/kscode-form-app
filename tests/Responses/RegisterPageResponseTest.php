<?php

namespace App\Tests\Responses;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterPageResponseTest extends WebTestCase
{
    public function test_registerPageResponse_success(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Register');
    }
}
