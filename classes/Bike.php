<?php

declare(strict_types=1);

require_once("Database.php");

class Bike
{
    private string $framenummer;
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
}
