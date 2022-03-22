<?php

declare(strict_types=1);

require_once("Database.php");

class Bike
{
    private string $framenummer;
    private string $comment;

    public function __construct(string $framenummer, string $comment)
    {
        $this->framenummer = $framenummer;
        $this->comment = $comment;
    }

    public function getFramenummer(): string
    {
        return $this->framenummer;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public static function getTotalBikeCount(): int
    {
        $sth = Database::getPDO()->prepare("SELECT 1 FROM `bike` WHERE `framenummer` != '';");
        $sth->execute();
        return $sth->rowCount();
    }

    public static function getBikes(): array
    {
        $sth = Database::getPDO()->prepare("SELECT `framenummer`, `comment` FROM `bike` WHERE `framenummer` != '';");
        $sth->execute();

        $bikes = array();

        while ($row = $sth->fetch())
        {
            $bikes[] = new Bike($row["framenummer"], $row["comment"]);
        }

        return $bikes;
    }
}
