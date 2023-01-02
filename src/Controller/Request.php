<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class Request
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
    }

    public function validate(): array
    {
        $errors = $this->validator->validate($this);

        $messages = [];

        /** @var \Symfony\Component\Validator\ConstraintViolation $message */
        foreach ($errors as $message) {
            $messages[$message->getPropertyPath()] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        return $messages;
    }

    public function getRequest(): SymfonyRequest
    {
        return SymfonyRequest::createFromGlobals();
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->request->all() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}