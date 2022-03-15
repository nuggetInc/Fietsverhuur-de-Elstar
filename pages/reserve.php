<?php

declare(strict_types=1);

if (!isset($_SESSION["user"]))
{
    header("Location: ../");
    exit;
}

?>
<div class="form-wrapper">
    <form action="" method="post">
        <input type="text" name="searchBikeCount">
        <input type="submit">
    </form>
</div>


<table>
    <tr>
        <th>Maandag</th>
        <th>Dinsdag</th>
        <th>Woensdag</th>
        <th>Donderdag</th>
        <th>Vrijdag</th>
        <th>Zaterdag</th>
        <th>Zondag</th>
    </tr>
    <?php

    $totalBikeCount = (new Bike)->getTotalBikeCount();
    $bikeRental = new BikeRental();


    $getdate_wday = (getdate()["wday"] == 0) ? 6 : getdate()["wday"] - 1;
    $date = date("d-m-Y", strtotime("-" . $getdate_wday .  " days"));

    for($j = 0; $j < 20; $j++) 
    {
        echo "<tr>";
        for($i = 0; $i < 7; $i++) 
        {
            $bikeRental->setDate(date("Y-m-d", strtotime($date)));
            $bikeCountReserved= $totalBikeCount - count($bikeRental->getReserved());
            $color = ($date == date("d-m-Y")) ? "green" : ((getdate(strtotime($date))["wday"] == 6 ||getdate(strtotime($date))["wday"]== 0) ? "gray" : "lightgray");

            echo "
            <td style='background-color: {$color}'>
                <p class='table-text'>{$date}</p>
                <p class='table-text'> {$bikeCountReserved}/{$totalBikeCount}</p>
                <button><a>Reserveer</a></button>
            </td>";
            $date = date("d-m-Y", strtotime($date .  "+1 days"));
        }
        echo "</tr>";
    }
    ?>
</table>