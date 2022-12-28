<?php

namespace App\Security;

#[\Attribute(\Attribute::TARGET_METHOD)]
class IsPermissionGranted
{
    private string $resource;
    private string $access;

    public function __construct(string $resource, string $access)
    {
        $this->resource = $resource;
        $this->access = $access;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function getAccess(): string
    {
        return $this->access;
    }
}