<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class UserEditTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
//        $I->loginAsAdmin();

        $this->tester->amOnPage('/user/3/edit');

        $this->tester->fillField('userName', "EditUser-" . date("YmdHis"));

        $this->tester->click('Submit');
        $this->tester->see('EditUSer-');
    }
}
