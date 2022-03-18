<?php

declare(strict_types=1);

if (isset($_POST["remove_page"]))
{
    Page::remove($_POST["name"]);

    header("Location: ?" . http_build_query($_GET));
    exit;
}

?>
<form method="POST">
    <header>Remove Page</header>

    <label class="field">
        <header>
            <h3>Name</h3>
        </header>
        <input type="text" name="name" placeholder="name" autofocus onfocus="this.select()" />
    </label>

    <input type="submit" name="remove_page" value="Remove" />
</form>