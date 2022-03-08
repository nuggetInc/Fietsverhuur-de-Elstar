<?php

declare(strict_types=1);

require_once("../classes/Employee.php");

session_start();

if (!isset($_SESSION["user"]))
{
    header("Location: ../");
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>

<body>
    <p><a href="logout.php">Logout</a></p>
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

        for ($j = 0; $j < 4; $j++)
        {
            echo "<tr>";
            for ($i = 0; $i < 7; $i++)
            {
                $color = ($date == date("d-m-Y")) ? "green" : "gray";


                echo "<td style='background-color: {$color}'>{$date}</td>";


                $date = date("d-m-Y", strtotime($date .  "+1 days"));
            }
            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>