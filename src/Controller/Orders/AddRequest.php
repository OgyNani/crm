<?php

namespace App\Controller\Orders;

use App\Controller\Request;
use Symfony\Component\Validator\Constraints;

class AddRequest extends Request
{
    #[Constraints\Type('numeric')]
    #[Constraints\NotBlank]
    public $orderId;

    #[Constraints\Type('numeric')]
    #[Constraints\NotBlank]
    public $orderProducts;

    #[Constraints\Type('string')]
    #[Constraints\NotBlank]
    public $country;

    #[Constraints\Type('string')]
    #[Constraints\NotBlank]
    public $status;

    #[Constraints\Type('numeric')]
    #[Constraints\NotBlank]
    public $orderSum;

    #[Constraints\Type('numeric')]
    #[Constraints\NotBlank]
    public $clientId;
}