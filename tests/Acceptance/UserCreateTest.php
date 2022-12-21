<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class UserCreateTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
//        $I->loginAsAdmin();

        $this->tester->amOnPage('/user/create');

        $this->tester->fillField('userName', "User-" . date("YmdHis"));

        $this->tester->fillField('password', 'PW' . date('YmdHis'));

        $this->tester->click('Submit');
        $this->tester->see('User-');
    }
}
