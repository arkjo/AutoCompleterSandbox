<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuthorControllerTest extends WebTestCase
{
    public function testSearch(): void
    {
        $client = static::createClient();
        $client->request('GET', '/search-author?q=a');
        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testGetOk(): void
    {
        $client = static::createClient();
        $client->request('GET', '/get-author/1');
        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testGetInvalid(): void
    {
        $client = static::createClient();
        $client->request('GET', '/get-author/0');
        $this->assertTrue($client->getResponse()->isClientError());
    }

    public function testNew(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/new-author');
        $this->assertTrue($client->getResponse()->isOk());
        $form = $crawler->selectButton('OK')->form([
            'author[name]' => 'A test author',
        ]);
        $client->submit($form);
        $client->followRedirect();
        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testNewAjax(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/new-author');
        $csrf = $crawler->filter('#author__token')->attr('value');
        $put = ['author' => ['name' => 'A test author via ajax', '_token' => $csrf]];
        $client->request('PUT', '/new-author', $put, [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertTrue($client->getResponse()->isOk());
    }
}
