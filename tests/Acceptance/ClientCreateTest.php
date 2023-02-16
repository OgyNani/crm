<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class ClientCreateTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    // tests
    public function testSomeFeature()
    {
        $this->tester->loginAsAdmin();

        $this->tester->amOnPage('/client/create');

        $this->tester->fillField('userName', "Client-" . date("YmdHis"));

        $this->tester->fillField('contact', 'Testing');

        $this->tester->selectOption('country', 'Armenia');

        $this->tester->click('Submit');
        $this->tester->see('Testing');
    }
}
