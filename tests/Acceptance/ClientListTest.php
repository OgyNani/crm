<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class ClientListTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    // tests
    public function testSomeFeature()
    {
        $this->tester->loginAsAdmin();

        $this->tester->amOnPage('/clients/list');

        $this->tester->see('Clients');
        $this->tester->see('iidsdsattt');
    }
}
