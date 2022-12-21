<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class ClientEditTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
//        $I->loginAsAdmin();

        $this->tester->amOnPage('/client/5/edit');

        $this->tester->fillField('userName', "EditClient-" . date("YmdHis"));

        $this->tester->fillField('contact', "EditContact-" . date("YmdHis"));

        $this->tester->fillField('country', "EditCountry-" . date("YmdHis"));

        $this->tester->click('Submit');
        $this->tester->see('EditClient-');
    }
}
