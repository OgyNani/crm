<?php

namespace App\Controller\Clients;

use App\Controller\Request;
use Symfony\Component\Validator\Constraints;

class AddRequest extends Request
{
    #[Constraints\Type('numeric')]
    #[Constraints\NotBlank]
    public $userId;

    #[Constraints\Type('string')]
    #[Constraints\NotBlank]
    public $userName;

    #[Constraints\Type('string')]
    #[Constraints\NotBlank]
    public $country;

    #[Constraints\Type('string')]
    #[Constraints\NotBlank]
    public $contact;
}