<?php

declare(strict_types=1);

?>
<header id="header">
    <ul>
        <!-- Like the switch below this is only temporary -->
        <li><a href="?page=logout">Logout</a></li>
        <li><a href="?page=reserve">Reserve</a></li>
        <li><a href="?page=employees">Employees</a></li>
    </ul>
</header>
<div class="page-wrapper">
    <?php

    // Just default to reserve
    $page = $_GET["page"] ?? "reserve";

    // We could use a string literals here to load the page,
    // but that would cause vulnerabilities because it would be able to load every file by editing the GET variable.
    // This only is a temporary solution.
    switch ($page)
    {
        case "reserve":
            require("pages/reserve.php");
            break;
        case "logout":
            require("pages/logout.php");
            break;
        case "employees":
            require("pages/employees.php");
            break;
    }

    ?>
</div>