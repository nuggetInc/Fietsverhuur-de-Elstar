<?php

declare(strict_types=1);

if (isset($_POST["update"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["name"] = $_POST["name"];

    $_SESSION["permission"] = $_POST["permission"];

    Employee::update($_POST["name"], Permission::from($_POST["permission"]));

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
    <header>Zoeken</header>

    <label class="field">
        <header>
            <h3>Zoeken</h3>
            <?php if (count($employees) === 0) : ?>
                <span class="error">Geen werknemers gevonden</span>
            <?php endif ?>
        </header>
        <input type="text" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" placeholder="Gebruikersnaam" autofocus onfocus="this.select()" />
    </label>

    <?php if (count($employees) > 0) : ?>
        <label class="field">
            <header>
                <h3>Naam</h3>
                <?php if (!isset($employee)) : ?>
                    <span class="error">Die werknemer bestaat niet :(</span>
                <?php endif ?>
            </header>
            <select name="name">
                <?php foreach ($employees as $item) : ?>
                    <?php if (isset($_SESSION["name"]) && $_SESSION["name"] === $item->getName()) : ?>
                        <option value="<?= htmlspecialchars($item->getName()) ?>" selected><?= htmlspecialchars($item->getName()) ?></option>
                    <?php else : ?>
                        <option value="<?= htmlspecialchars($item->getName()) ?>"><?= htmlspecialchars($item->getName()) ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </label>
    <?php endif ?>

    <input type="submit" name="search" value="Zoeken" />
</form>
<?php if (isset($employee)) : ?>
    <form method="POST">
        <header>Aanpassen</header>

        <input type="hidden" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" />
        <input type="hidden" name="name" value="<?= htmlspecialchars($employee->getName()) ?>" />

        <div class="field">
            <header>
                <h3>Toestemming</h3>
                <span id="register-permission-error" class="error">
                    <?= $_SESSION["register-permission-error"] ?? "" ?>
                </span>
            </header>
            <div class="inline">
                <label>
                    <input type="radio" name="permission" value="user" <?= $employee->getPermission() === Permission::USER ? "checked" : null ?> />
                    Gebruiker
                </label>
                <label>
                    <input type="radio" name="permission" value="admin" <?= $employee->getPermission() === Permission::ADMIN ? "checked" : null ?> />
                    Administrator
                </label>
            </div>
        </div>

        <input type="submit" name="update" value="Aanpassen" />
    </form>
<?php endif ?>
<?php

unset($_SESSION["match"]);
unset($_SESSION["name"]);

?>