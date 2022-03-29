<?php 

declare(strict_types=1);

class ReserverTable 
{
    private int $weekCount;
    private string $startDate;
    private $bikeRental;
    private int $totalBikeCount;
    private string $buttonText;
    private string $buttonLink;

    public function __construct()
    {
        $this->bikeRental = new BikeRental();
        $this->totalBikeCount = Bike::getTotalBikeCount();
    }

    public function setWeekCount($value)
    {
        $this->weekCount = $value;
    }
    public function setStartDate($value)
    {
        $this->startDate = $value;
    }
    public function setButtonText($value)
    {
        $this->buttonText = $value;
    }
    public function setButtonLink($value)
    {
        $this->buttonLink = $value;
    }
     
    public function getTable()
    {
        $getdate_wday = (getdate(strtotime($this->startDate))["wday"] == 0) ? 6 : getdate(strtotime($this->startDate))["wday"] - 1;
        $formatDate = date("d-m-Y", strtotime($this->startDate));
        $date = date("d-m-Y", strtotime($formatDate . "-". $getdate_wday . " days"));
        $trId = 0;

        $table = "<table>
        <tr>
        <th>Maandag</th>
        <th>Dinsdag</th>
        <th>Woensdag</th>
        <th>Donderdag</th>
        <th>Vrijdag</th>
        <th>Zaterdag</th>
        <th>Zondag</th>
        </tr>";

        for ($j = 0; $j < $this->weekCount; $j++)
        {
            
            $table.= "<tr>";
            for ($i = 0; $i < 7; $i++)
            {
                $this->bikeRental->setDate(date("Y-m-d", strtotime($date)));
                $this->bikeRental->setStatus(1);
                $bikeCountReserved = $this->totalBikeCount - count($this->bikeRental->getDate());
                $trId++;
                $class = "";
                if (isset($_POST["numberOfPeople"]) && $_POST["numberOfPeople"] > $bikeCountReserved)
                {
                    $class = "dayfull";
                }
                else if ($date == date("d-m-Y"))
                {
                    $class = "dayfree";
                }
                else if (getdate(strtotime($date))["wday"] == 6 || getdate(strtotime($date))["wday"] == 0)
                {
                    $class = "weekend";
                }
                else
                {
                    $class = "weekday";
                }
                $table.= "
                <td id='td{$trId}' onclick='selectTd(\"td{$trId}\", \"{$date}\")' class='{$class}'>
                    <p class='table-text'>{$date}</p>
                    <p class='table-text'> {$bikeCountReserved}/{$this->totalBikeCount}</p>
                </td>";
                $date = date("d-m-Y", strtotime($date .  "+1 days"));
            }
            $table.= "</tr>";
        }
        $table.= "</table>";
        return $table;
    }
}

?>