<?php

declare(strict_types=1);

require_once("classes/Permission.php");

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
