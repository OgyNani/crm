<?php


namespace App\Tests\Functional;

use App\Entity\Role;
use App\Repository\RoleRepository;
use App\Tests\FunctionalTester;

class RoleDeleteTest extends \Codeception\Test\Unit
{

    protected FunctionalTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {

        $this->tester->loginAsAdmin();

        // pre conditions
        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->tester->grabService(RoleRepository::class);

        $role = new Role('Testing', 'ROLE_TESTING');
        $roleRepository->save($role);

        $this->tester->amOnPage('/roles/list');
        $this->tester->see($role->getName());

        // act
        $this->tester->amOnPage("/role/{$role->getId()}/delete");

        // assert
        $this->tester->dontSee($role->getName());
    }
}
