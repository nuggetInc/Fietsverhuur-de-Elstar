<?php

declare(strict_types=1);

?>
<header>
    <ul>
        <li><a href="?page=logout">Logout<a></li>
    </ul>
</header>
<div class="page-wrapper">
    <?php

    $page = $_GET["page"] ?? null;

    switch ($page)
    {
        case "reserve":
            require("pages/reserve.php");
            break;
        case "logout":
            require("pages/logout.php");
            break;
        case null:
            require("pages/reserve.php");
            break;
    }

    ?>
</div>