<?php

namespace App\Tests\Unit\Controller\Client;

use App\Controller\Clients\Add;
use App\Controller\Clients\AddRequest;
use App\Repository\InMemoryClientRepository;
use PHPUnit\Framework\TestCase;

class AddTest extends TestCase
{
    public function test(): void
    {
        $repository = new InMemoryClientRepository();

        $addController = new Add($repository);

        $request = new AddRequest();
        $request->userId = 11;
        $request->userName = 'John';
        $request->country = 'Latvija';
        $request->contact = 'john@mail.com';
        $addController->do($request);

        $client = $repository->findByUserName('John');

        $this->assertEquals('john@mail.com', $client->getContact());
    }
}
