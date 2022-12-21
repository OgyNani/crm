<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class ClientListTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
//        $I->loginAsAdmin();

        $this->tester->amOnPage('/clients/list');

        $this->tester->see('Clients');
        $this->tester->see('iidsdsattt');
    }
}
