<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class UserCreateTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    // tests
    public function testSomeFeature()
    {
        $this->tester->loginAsAdmin();

        $this->tester->amOnPage('/user/create');

        $this->tester->fillField('userName', "User-" . date("YmdHis"));

        $this->tester->selectOption('roleId', '1');

        $this->tester->fillField('password', 'PW' . date('YmdHis'));

        $this->tester->click('Submit');
        $this->tester->see('User-');
    }
}
