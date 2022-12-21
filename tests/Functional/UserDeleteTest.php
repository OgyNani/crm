<?php


namespace App\Tests\Functional;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\FunctionalTester;

class UserDeleteTest extends \Codeception\Test\Unit
{

    protected FunctionalTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testUserDeleting()
    {
        // pre conditions
        /** @var UserRepository $userRepository */
        $userRepository = $this->tester->grabService(UserRepository::class);

        $user = new User('U1', 'p1');
        $userRepository->save($user);

        $this->tester->amOnPage('/user/list');
        $this->tester->see($user->getUsername());

        // act
        $this->tester->amOnPage("/user/{$user->getId()}/delete");

        // assert
        $this->tester->dontSee($user->getUsername());
    }
}
