<?php

declare(strict_types=1);

class Page
{
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getChildren(): array
    {
        $params = array(":parent" => $this->name);
        $sth = Database::getPDO()->prepare("SELECT `name` FROM `page` WHERE `parent` = :parent ORDER BY `order`;");
        $sth->execute($params);

        $children = array();

        while ($row = $sth->fetch())
        {
            $child = new Page($row["name"]);
            $children[] = $child;
        }

        return $children;
    }

    public static function getRootChildren(): array
    {
        $sth = Database::getPDO()->prepare("SELECT `name` FROM `page` WHERE `parent` = '' ORDER BY `order`;");
        $sth->execute();

        $children = array();

        while ($row = $sth->fetch())
        {
            $child = new Page($row["name"]);
            $children[] = $child;
        }

        return $children;
    }
}
