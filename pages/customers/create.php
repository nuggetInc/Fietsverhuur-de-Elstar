<?php

declare(strict_types=1);

if (isset($_POST["create"]))
{
    if (@$_POST["salutation"] === "")
    {
        $_SESSION["salutation-error"] = "Salutation kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }
    $_SESSION["salutation"] = $_POST["salutation"];

    if (@$_POST["name"] === "")
    {
        $_SESSION["name-error"] = "Name kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }
    $_SESSION["name"] = $_POST["name"];

    if (@$_POST["surname"] === "")
    {
        $_SESSION["surname-error"] = "Surname kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }
    $_SESSION["surname"] = $_POST["surname"];

    if (@$_POST["email"] === "")
    {
        $_SESSION["email-error"] = "E-mail kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }
    $_SESSION["email"] = $_POST["email"];

    if (@$_POST["phonenumber"] === "")
    {
        $_SESSION["phonenumber-error"] = "Telefoonnummer kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }
    $_SESSION["phonenumber"] = $_POST["phonenumber"];

    if (@$_POST["postalcode"] === "")
    {
        $_SESSION["postalcode-error"] = "Postcode kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }

    unset($_SESSION["salutation"]);
    unset($_SESSION["name"]);
    unset($_SESSION["surname"]);
    unset($_SESSION["email"]);
    unset($_SESSION["phonenumber"]);

    Customer::create($_POST["salutation"], $_POST["name"], $_POST["surname"], $_POST["email"], $_POST["phonenumber"], $_POST["postalcode"]);

    header("Location: $uri");
    exit;
}

?>
<form method="POST" onsubmit="return validateCreateForm()">
    <header>Creëer</header>

    <label class="field">
        <header>
            <h3>Aanhef</h3>
        </header>
        <input type="text" name="salutation" value="<?= htmlspecialchars($_SESSION["salutation"] ?? "") ?>" placeholder="Aanhef" autofocus onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Voornaam</h3>
        </header>
        <input type="text" name="name" value="<?= htmlspecialchars($_SESSION["name"] ?? "") ?>" placeholder="Voornaam" onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Achternaam</h3>
        </header>
        <input type="text" name="surname" value="<?= htmlspecialchars($_SESSION["surname"] ?? "") ?>" placeholder="Achternaam" onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>E-Mail</h3>
        </header>
        <input type="text" name="email" value="<?= htmlspecialchars($_SESSION["email"] ?? "") ?>" placeholder="E-Mail" onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Telefoonnummer</h3>
        </header>
        <input type="text" name="phonenumber" value="<?= htmlspecialchars($_SESSION["phonenumber"] ?? "") ?>" placeholder="Telefoonnummer" onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Postcode</h3>
        </header>
        <input type="text" name="postalcode" value="<?= htmlspecialchars($_SESSION["postalcode"] ?? "") ?>" placeholder="Postcode" onfocus="this.select()" />
    </label>

    <input type="submit" name="create" value="Creëer" />
</form>
<!-- <script type="text/javascript">
    const framenumberInput = document.getElementById("framenumber");
    const framenumberError = document.getElementById("framenumber-error");

    function validateCreateForm() {
        if (framenumberInput.value === "") {
            framenumberError.innerHTML = "Framenummer kan niet leeg zijn";
            return false;
        }

        return true;
    }

    function validateFramenumber() {
        if (framenumberInput.value === "") {
            framenumberError.innerHTML = "Framenummer kan niet leeg zijn";
        } else {
            framenumberError.innerHTML = "";
        }
    }
</script> -->
<?php

unset($_SESSION["salutation"]);
unset($_SESSION["name"]);
unset($_SESSION["surname"]);
unset($_SESSION["email"]);
unset($_SESSION["phonenumber"]);
unset($_SESSION["postalcode"]);

?>