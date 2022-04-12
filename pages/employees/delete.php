<?php

declare(strict_types=1);

if (isset($_POST["delete"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["name"] = $_POST["name"];
    Employee::delete($_POST["name"]);

    header("Location: $uri");
    exit;
}

if (isset($_POST["match"], $_POST["name"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["name"] = $_POST["name"];

    header("Location: $uri");
    exit;
}

$match = "%";
if (isset($_SESSION["match"]))
{
    $match .= $_SESSION["match"] . "%";
}

$employees = Employee::like($match);
if (count($employees) > 0)
{
    if (array_key_exists(@$_SESSION["name"], $employees))
        $employee = $employees[$_SESSION["name"]];
    else
        $employee = $employees[key($employees)];
}

?>
<form method="POST" onchange="this.submit()">
    <header>Verwijderen</header>

    <label class="field">
        <header>
            <h3>Zoeken</h3>
        </header>
        <input type="text" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" placeholder="Gebruikersnaam" autofocus onfocus="this.select()" />
    </label>

    <?php if (count($employees) > 0) : ?>
        <label class="field">
            <header>
                <h3>Werknemer</h3>
            </header>

            <select name="name">
                <?php foreach ($employees as $item) : ?>
                    <?php if (isset($_SESSION["name"]) && $_SESSION["name"] === $item->getName()) : ?>
                        <option value="<?= $item->getName() ?>" selected><?= htmlspecialchars($item->getName()) ?></option>
                    <?php else : ?>
                        <option value="<?= $item->getName() ?>"><?= htmlspecialchars($item->getName()) ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </label>
    <?php endif ?>

    <input type="submit" name="search" value="Zoeken" />
</form>
<?php if (isset($employee)) : ?>
    <form method="POST">
        <input type="hidden" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" />
        <input type="hidden" name="name" value="<?= htmlspecialchars($_SESSION["name"] ?? "") ?>" />

        <input type="submit" name="delete" value="Verwijderen" />
    </form>
<?php endif ?>
<?php

unset($_SESSION["match"]);
unset($_SESSION["name"]);

?>