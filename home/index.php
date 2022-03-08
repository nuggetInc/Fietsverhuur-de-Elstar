<?php 
declare(strict_types=1);
?>

<!DOCTYPE html>
<html>
<head>
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
                for($j = 0; $j < 4; $j++) 
                {
                    echo "<tr>";
                    for($i = 0; $i < 7; $i++) 
                    {
                        echo "<td>25-05-2022</td>";

                    }
                    echo "</tr>";
                }
            
            ?>
    </table>
</body>
</html>


