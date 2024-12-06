<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// tests fonctionnels
class BucketTest extends WebTestCase
{
    public function testHomePageIsWorking(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Welcome in Bucket List');
    }

    public function testCreateWishIfNotLogged(): void {
        $client = static::createClient();
        $crawler = $client->request('GET', '/wishes/create');

        $this->assertResponseRedirects('/login', 302);
    }

    public function testCreateWishIfLogged(): void {
        $client = static::createClient();

        $userRepository = self::getContainer()->get(UserRepository::class);
//        $user = $userRepository->findOneBy(['email' => 'cecile.n.jeanneau@gmail.com']);
        $user = $userRepository->find(1);

        $client->loginUser($user);

        $crawler = $client->request('GET', '/wishes/create');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Create a Wish !!', [
            'wish[title]' => 'Wish test',
            'wish[description]' => 'Wish description',
            'wish[category]' => '8',
        ]);

        $this->assertResponseStatusCodeSame(302);
        $client->followRedirects();
//        $this->assertResponseRedirects('#^/wishes/details/');

        $this->assertRouteSame('wishes_details');
    }
}
