<?php

declare(strict_types=1);

class Employee
{
    private string $name;
    private Permission $permission;

    public function __construct(string $name, Permission $permission)
    {
        $this->name = $name;
        $this->permission = $permission;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPermission(): Permission
    {
        return $this->permission;
    }
}

enum Permission: string
{
    case user = "user";
    case admin = "admin";
}
