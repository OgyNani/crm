<?php

namespace App\Security;

class AnnotationReader
{
    public function getMethodAnnotation(string $class, string $method, string $annotationType): ?object
    {
        $reflectionMethod = new \ReflectionMethod($class, $method);

        $attributes = $reflectionMethod->getAttributes($annotationType);

        if (!isset($attributes[0])) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}