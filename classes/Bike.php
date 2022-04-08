<?php

declare(strict_types=1);

require_once("Database.php");

class Bike
{
    private string $framenumber;
    private string $comment;

    public function __construct(string $framenumber, string $comment)
    {
        $this->framenumber = $framenumber;
        $this->comment = $comment;
    }

    public function getFramenumber(): string
    {
        return $this->framenumber;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public static function getTotalBikeCount(): int
    {
        $sth = Database::getPDO()->prepare("SELECT 1 FROM `bike` WHERE `framenumber` != '';");
        $sth->execute();
        return $sth->rowCount();
    }

    public static function getBike(string $framenumber): ?Bike
    {
        $params = array(":framenumber" => $framenumber);
        $sth = Database::getPDO()->prepare("SELECT `framenumber`, `comment` FROM `bike` WHERE `framenumber` = :framenumber LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
        {
            return new Bike($row["framenumber"], $row["comment"]);
        }

        return null;
    }

    public static function getBikes(): array
    {
        $sth = Database::getPDO()->prepare("SELECT `framenumber`, `comment` FROM `bike` WHERE `framenumber` != '';");
        $sth->execute();

        $bikes = array();

        while ($row = $sth->fetch())
        {
            $bikes[] = new Bike($row["framenumber"], $row["comment"]);
        }

        return $bikes;
    }

    public static function getFramenumbers(): array
    {
        $sth = Database::getPDO()->prepare("SELECT `framenumber` FROM `bike` WHERE `framenumber` != '';");
        $sth->execute();

        $framenumbers = array();

        while ($row = $sth->fetch())
        {
            $framenumbers[] = $row["framenumber"];
        }

        return $framenumbers;
    }

    public static function getFramenumbersLike(string $match)
    {
        $params = array(":match" => $match);
        $sth = Database::getPDO()->prepare("SELECT `framenumber` FROM `bike` WHERE `framenumber` != '' and `framenumber` LIKE :match;");
        $sth->execute($params);

        $framenumbers = array();

        while ($row = $sth->fetch())
        {
            $framenumbers[] = $row["framenumber"];
        }

        return $framenumbers;
    }

    public static function update(string $framenumber, string $comment)
    {
        $params = array(":framenumber" => $framenumber, "comment" => $comment);
        $sth = Database::getPDO()->prepare("UPDATE `bike` SET `comment` = :comment WHERE `framenumber` = :framenumber;");
        $sth->execute($params);
    }

    public static function create(string $framenumber, string $comment)
    {
        $params = array(":framenumber" => $framenumber, "comment" => $comment);
        $sth = Database::getPDO()->prepare("INSERT INTO `bike` (`framenumber`, `comment`) VALUES (:framenumber, :comment);");
        $sth->execute($params);
    }
}
