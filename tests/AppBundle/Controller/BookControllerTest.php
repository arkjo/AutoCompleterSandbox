<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class BookControllerTest extends WebTestCase
{
    public function testNew(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/new-book');
        $this->assertTrue($client->getResponse()->isOk());
        $form = $crawler->selectButton('OK')->form([
            'book[title]' => 'A test book',
            'book[author]' => '1',
        ]);
        $client->submit($form);
        $client->followRedirect();
        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testEdit(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $crawler = $client->click($crawler->selectLink('edit')->link());
        $this->assertTrue($client->getResponse()->isOk());
        $form = $crawler->selectButton('OK')->form([
            'book[title]' => 'Changed title',
        ]);
        $client->submit($form);
        $client->followRedirect();
        $this->assertTrue($client->getResponse()->isOk());
    }
}
