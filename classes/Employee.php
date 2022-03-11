<?php

declare(strict_types=1);

require_once("classes/Permission.php");

class Employee
{
    private int $id;
    private string $name;
    private Permission $permission;

    public function __construct(int $id, string $name, Permission $permission)
    {
        $this->id = $id;
        $this->name = $name;
        $this->permission = $permission;
    }

    public function getId(): int
    {
        return $this->id;
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
