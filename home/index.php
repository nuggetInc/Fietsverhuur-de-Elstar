<?php 
declare(strict_types=1);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
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

            $getdate_wday = (getdate()["wday"] == 0) ? 7 : getdate()["wday"] - 1;
            $date = date("d-m-Y", strtotime("-" . $getdate_wday .  " days"));

            for($j = 0; $j < 20; $j++) 
            {
                echo "<tr>";
                for($i = 0; $i < 7; $i++) 
                {
                    $color = ($date == date("d-m-Y")) ? "green" : ((getdate(strtotime($date))["wday"] == 6 ||getdate(strtotime($date))["wday"]== 0) ? "gray" : "lightgray");
                    echo "
                    <td style='background-color: {$color}'>
                        <p class='table-text'>{$date}</p>
                        <p class='table-text'>25/100</p>

                    </td>";
                    $date = date("d-m-Y", strtotime($date .  "+1 days"));

                }
                echo "</tr>";
            }
            
            ?>
    </table>
</body>
</html>


