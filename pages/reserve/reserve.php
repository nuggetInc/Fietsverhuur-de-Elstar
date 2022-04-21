<?php
declare(strict_types=1);

?>

<table>
    <thead>
        <tr>
            <th>Maandag</th>
            <th>Dinsdag</th>
            <th>Woensdag</th>
            <th>Donderdag</th>
            <th>Vrijdag</th>
            <th>Zaterdag</th>
            <th>Zondag</th>
        </tr>
    </thead>
<?php 


$dateNow = (getdate()["wday"] == 0) ? 6 : getdate()["wday"] - 1;
$date = date('d-m-Y', strtotime("-" . $dateNow . " days"));

for($i = 0; $i < 10; $i++) 
{
    echo"<tr>";
    for($j = 0; $j < 7; $j++) 
    {
        $class = "weekday";
        if($date == date('d-m-Y'))
        {
            $class = "dayfree";
        }
        else if(getdate(strtotime($date))["wday"] == 0 || getdate(strtotime($date))["wday"] == 6)
        {
            $class = "weekend";
        }
        $bikeCount =  BikeRental::getCountByDate($date) . " / " . Bike::getTotalBikeCount();
        echo"<td class='{$class}'>{$date}<br><strong>{$bikeCount}</strong></td>";
        $date = date('d-m-Y', strtotime($date . "+1 day"));
    }
    echo"<tr>";
}

?>
</table>