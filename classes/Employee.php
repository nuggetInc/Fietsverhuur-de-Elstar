<?php

declare(strict_types=1);

require_once("classes/Database.php");

class Employee
{
    private string $name;
    private string $hash;
    private Permission $permission;

    private function __construct(string $name, string $hash, Permission $permission)
    {
        $this->name = $name;
        $this->hash = $hash;
        $this->permission = $permission;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getPermission(): Permission
    {
        return $this->permission;
    }

    /** Check if a user exist */
    public static function exists(string $name): bool
    {
        $params = array(":name" => $name);
        $sth = Database::getPDO()->prepare("SELECT 1 FROM `employee` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        return $sth->rowCount() === 1;
    }

    /** Create a user object from name */
    public static function fromName(string $name): ?Employee
    {
        $params = array(":name" => $name);
        $sth = Database::getPDO()->prepare("SELECT `name`, `hash`, `permission` FROM `employee` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
        {
            $name = $row["name"];
            $hash = $row["hash"];
            $permission = Permission::from($row["permission"]);
            return new Employee($name, $hash, $permission);
        }

        return null;
    }

    /** Get all the users that match a string */
    public static function like($match): array
    {
        $params = array(":match" => $match);
        $sth = Database::getPDO()->prepare("SELECT `name`, `hash`, `permission` FROM `employee` WHERE `name` LIKE :match;");
        $sth->execute($params);

        $employees = array();

        while ($row = $sth->fetch())
        {
            $name = $row["name"];
            $hash = $row["hash"];
            $permission = Permission::from($row["permission"]);
            $employees[$row["name"]] = new Employee($name, $hash, $permission);
        }

        return $employees;
    }

    /** Register a new user */
    public static function register(string $name, string $password, Permission $permission): Employee
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $params = array(":name" => $name, ":hash" => $hash, ":permission" => $permission->value);
        $sth = Database::getPDO()->prepare("INSERT INTO `employee` (`name`, `hash`, `permission`) VALUES (:name, :hash, :permission);");
        $sth->execute($params);

        return new Employee($name, $hash, $permission);
    }

    public static function update(string $name, Permission $permission)
    {
        $params = array(":name" => $name, ":permission" => $permission->value);
        $sth = Database::getPDO()->prepare("UPDATE `employee` SET `permission` = :permission WHERE `name` = :name;");
        $sth->execute($params);
    }

    public static function delete(string $name)
    {
        $params = array(":name" => $name);
        $sth = Database::getPDO()->prepare("DELETE FROM `employee` WHERE `name` = :name;");
        $sth->execute($params);
    }
}

enum Permission: string
{
    case USER = "user";
    case ADMIN = "admin";
}
