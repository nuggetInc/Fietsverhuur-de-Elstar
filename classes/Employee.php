<?php

declare(strict_types=1);

class Employee
{
    private string $name;
    private string $permission;

    public function __construct(string $name, string $permission)
    {
        $this->name = $name;
        $this->permission = $permission;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPermission(): string
    {
        return $this->permission;
    }
}
