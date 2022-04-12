<?php

declare(strict_types=1);

if (isset($_POST["update"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["framenumber"] = $_POST["framenumber"];

    Bike::update($_POST["framenumber"], $_POST["comment"]);

    header("Location: $uri");
    exit;
}

if (isset($_POST["match"], $_POST["framenumber"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["framenumber"] = $_POST["framenumber"];

    header("Location: $uri");
    exit;
}

$match = "%";
if (isset($_SESSION["match"]))
{
    $match .= $_SESSION["match"] . "%";
}

$framenumbers = Bike::getFramenumbersLike($match);
if (count($framenumbers) > 0)
{
    if (array_search(@$_SESSION["framenumber"], $framenumbers, true) !== false)
        $bike = Bike::getBike($_SESSION["framenumber"]);
    else
        $bike = Bike::getBike($framenumbers[0]);
}

?>
<form method="POST" onchange="this.submit()">
    <header>Zoeken</header>

    <label class="field">
        <header>
            <h3>Zoeken</h3>
            <?php if (count($framenumbers) === 0) : ?>
                <span class="error">Geen fietsen gevonden</span>
            <?php endif ?>
        </header>
        <input type="text" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" placeholder="SA1234" autofocus onfocus="this.select()" />
    </label>

    <?php if (count($framenumbers) > 0) : ?>
        <label class="field">
            <header>
                <h3>Framenummer</h3>
                <?php if (!isset($bike)) : ?>
                    <span class="error">Dat framenumber bestaat niet :(</span>
                <?php endif ?>
            </header>
            <select name="framenumber">
                <?php foreach ($framenumbers as $framenumber) : ?>
                    <?php if (isset($_SESSION["framenumber"]) && $_SESSION["framenumber"] === $framenumber) : ?>
                        <option value="<?= htmlspecialchars($framenumber) ?>" selected><?= htmlspecialchars($framenumber) ?></option>
                    <?php else : ?>
                        <option value="<?= htmlspecialchars($framenumber) ?>"><?= htmlspecialchars($framenumber) ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </label>
    <?php endif ?>

    <input type="submit" name="search" value="Zoeken" />
</form>
<?php if (isset($bike)) : ?>
    <form method="POST">
        <header>Aanpassen</header>

        <input type="hidden" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" />
        <input type="hidden" name="framenumber" value="<?= htmlspecialchars($bike->getFramenumber()) ?>" />
        <label class="field">
            <header>
                <h3>Opmerking</h3>
            </header>
            <textarea name="comment"><?= $bike->getComment() ?></textarea>
        </label>

        <input type="submit" name="update" value="Aanpassen" />
    </form>
<?php endif ?>
<?php

unset($_SESSION["match"]);
unset($_SESSION["framenumber"]);

?>