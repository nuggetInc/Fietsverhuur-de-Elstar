<?php

declare(strict_types=1);

if (isset($_POST["search"]))
{
    if (isset($_POST["framenumber"]) && $_POST["framenumber"] !== "")
        $_SESSION["framenumber"] = $_POST["framenumber"];
    else
        $_SESSION["framenumber-error"] = "Framenummer kan niet leeg zijn :(";

    header("Location: $uri");
    exit;
}

if (isset($_POST["update"]))
{
    if (!isset($_POST["framenumber"]) || $_POST["framenumber"] === "")
    {
        $_SESSION["framenumber-error"] = "Framenummer kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }

    $_SESSION["framenumber"] = $_POST["framenumber"];

    Bike::update($_POST["framenumber"], $_POST["comment"]);

    header("Location: $uri");
    exit;
}

if (isset($_POST["create"]))
{
    if (!isset($_POST["framenumber"]) || $_POST["framenumber"] === "")
    {
        $_SESSION["framenumber-error"] = "Framenummer kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }

    $_SESSION["framenumber"] = $_POST["framenumber"];

    Bike::create($_POST["framenumber"], $_POST["comment"]);

    header("Location: $uri");
    exit;
}

?>
<form method="POST">
    <header>Zoeken</header>

    <label class="field">
        <header>
            <h3>Framenummer</h3>
            <span id="framenumber-error" class="error">
                <?= $_SESSION["framenumber-error"] ?? "" ?>
            </span>
        </header>
        <input id="framenumber" oninput="validateFramenumber()" type="text" name="framenumber" value="<?= htmlspecialchars($_SESSION["framenumber"] ?? "") ?>" placeholder="Framenumber" autofocus onfocus="this.select()" />
    </label>
    <input type="submit" name="search" value="Zoeken" />
</form>
<?php if (isset($_SESSION["framenumber"]) && $_SESSION["framenumber"] !== "") : ?>
    <form method="POST">
        <?php

        $bike = Bike::getBike($_SESSION["framenumber"]);

        ?>
        <?php if (isset($bike)) : ?>
            <header>Aanpassen</header>
        <?php else : ?>
            <header>Creëer</header>
        <?php endif ?>

        <?php if (isset($_SESSION["framenumber-error"])) : ?>
            <span class="error"><?= $_SESSION["framenumber-error"] ?></span>
        <?php endif ?>

        <input type="hidden" name="framenumber" value="<?= htmlspecialchars($_SESSION["framenumber"] ?? "") ?>" />
        <label class="field">
            <h3>Opmerking</h3>
            <textarea name="comment"><?= $bike?->getComment() ?></textarea>
        </label>

        <?php if (isset($bike)) : ?>
            <input type="submit" name="update" value="Aanpassen" />
        <?php else : ?>
            <input type="submit" name="create" value="Creëer" />
        <?php endif ?>
    </form>
<?php endif ?>
<?php

unset($_SESSION["framenumber"]);
unset($_SESSION["framenumber-error"]);

?>