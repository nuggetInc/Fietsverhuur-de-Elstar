<?php

declare(strict_types=1);

?>
<header id="header">
    <ul>
        <li><a href="?page=logout">Logout</a></li>
        <li><a href="?page=reserve">Reserve</a></li>
    </ul>
</header>
<div class="page-wrapper">
    <?php

    $page = $_GET["page"] ?? "reserve";

    switch ($page)
    {
        case "reserve":
            require("pages/reserve.php");
            break;
        case "logout":
            require("pages/logout.php");
            break;
    }

    ?>
</div>