<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class ClientCreateTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
//        $I->loginAsAdmin();

        $this->tester->amOnPage('/client/create');

        $this->tester->fillField('userName', "Client-" . date("YmdHis"));

        $this->tester->fillField('contact', 'Testing');

        $this->tester->fillField('country', 'Country' . date('YmdHis'));

        $this->tester->click('Submit');
        $this->tester->see('Testing');
    }
}
