<?php


namespace App\Tests\Functional;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Tests\FunctionalTester;

class ClientDeleteTest extends \Codeception\Test\Unit
{

    protected FunctionalTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $this->tester->loginAsAdmin();

        /** @var ClientRepository $clientRepository */
        $clientRepository = $this->tester->grabService(ClientRepository::class);

        $client = new Client(1, 'p1', 'Australia', 'testing@maik.com');
        $clientRepository->save($client);

        $this->tester->amOnPage('/clients/list');
        $this->tester->see($client->getUsername());

        // act
        $this->tester->amOnPage("/client/{$client->getId()}/delete");

        // assert
        $this->tester->dontSee($client->getUsername());
    }
}
