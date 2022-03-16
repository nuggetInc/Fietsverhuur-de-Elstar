<?php

declare(strict_types=1);

require_once("classes/Database.php");

class Page
{
    private string $name;
    private string $display;

    private function __construct(string $name, string $display)
    {
        $this->name = $name;
        $this->display = $display;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function getChildren(): array
    {
        $params = array(":parent" => $this->name);
        $sth = Database::getPDO()->prepare("SELECT `name`, `display` FROM `page` WHERE `parent` = :parent ORDER BY `order`;");
        $sth->execute($params);

        $children = array();

        while ($row = $sth->fetch())
        {
            $child = new Page($row["name"], $row["display"]);
            $children[] = $child;
        }

        return $children;
    }

    public static function getRootChildren(): array
    {
        $sth = Database::getPDO()->prepare("SELECT `name`, `display` FROM `page` WHERE `parent` = '' ORDER BY `order`;");
        $sth->execute();

        $children = array();

        while ($row = $sth->fetch())
        {
            $child = new Page($row["name"], $row["display"]);
            $children[] = $child;
        }

        return $children;
    }
}
