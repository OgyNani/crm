<?php


namespace App\Tests\Functional;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Tests\FunctionalTester;

class OrderCreateTest extends \Codeception\Test\Unit
{

    protected FunctionalTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {

        $this->tester->see('123123');

        $this->tester->amOnPage();

        // pre conditions
        /** @var OrderRepository $orderRepository */
        $orderRepository = $this->tester->grabService(OrderRepository::class);

        $order = new Order(
            '123123',
            '21',
            '1',
            'Australia',
            '23123',
            'Paid'
        );
        $orderRepository->save($order);

        $this->tester->amOnPage('/client/21/profile');
        $this->tester->see($order->getId());
    }
}
