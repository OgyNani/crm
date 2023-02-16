<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class UserEditTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    // tests
    public function testSomeFeature()
    {
        $this->tester->loginAsAdmin();

        $this->tester->amOnPage('/user/16/profile');

        $this->tester->click('#edit');

        $this->tester->fillField('userName', "EditUser-" . date("YmdHis"));

        $this->tester->click('Submit');
        $this->tester->see('EditUSer-');
    }
}
