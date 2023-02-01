<?php

namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class ClientEditTest extends \Codeception\Test\Unit
{
    protected AcceptanceTester $tester;

    // tests
    public function testSomeFeature()
    {
        $this->tester->loginAsAdmin();

        $this->tester->amOnPage('/client/21/edit');

        $this->tester->click('#edit');

        $this->tester->fillField('userName', "EditClient-" . date("YmdHis"));

        $this->tester->fillField('contact', "EditContact-" . date("YmdHis"));

        $this->tester->selectOption('country', 'Australia');

        $this->tester->click('Submit');
        $this->tester->see('EditClient-');
    }
}
