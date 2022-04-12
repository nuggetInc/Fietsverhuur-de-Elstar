<?php

declare(strict_types=1);

if (isset($_POST["create"]))
{
    $_SESSION["salutation"] = $_POST["salutation"];
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["surname"] = $_POST["surname"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["phonenumber"] = $_POST["phonenumber"];
    $_SESSION["postalcode"] = $_POST["postalcode"];

    if (@$_POST["salutation"] === "")
    {
        $_SESSION["salutation-error"] = "Salutation kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }

    if (@$_POST["name"] === "")
    {
        $_SESSION["name-error"] = "Naam kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }

    if (@$_POST["surname"] === "")
    {
        $_SESSION["surname-error"] = "Achternaam kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }

    if (@$_POST["phonenumber"] === "")
    {
        $_SESSION["phonenumber-error"] = "Telefoonnummer kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }

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
    unset($_SESSION["postalcode"]);

    Customer::create($_POST["salutation"], $_POST["name"], $_POST["surname"], $_POST["email"], $_POST["phonenumber"], $_POST["postalcode"]);

    header("Location: $uri");
    exit;
}

?>
<form method="POST" onsubmit="return validateCreateForm()">
    <header>Registreren</header>

    <label class="field">
        <header>
            <h3>Aanhef</h3>
            <span id="salutation-error" class="error">
                <?= $_SESSION["salutation-error"] ?? "" ?>
            </span>
        </header>
        <input id="salutation" type="text" name="salutation" value="<?= htmlspecialchars($_SESSION["salutation"] ?? "") ?>" placeholder="Dhr." oninput="validateSalutation()" autofocus onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Voornaam</h3>
            <span id="name-error" class="error">
                <?= $_SESSION["name-error"] ?? "" ?>
            </span>
        </header>
        <input id="name" type="text" name="name" value="<?= htmlspecialchars($_SESSION["name"] ?? "") ?>" placeholder="Jan" oninput="validateName()" onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Achternaam</h3>
            <span id="surname-error" class="error">
                <?= $_SESSION["surname-error"] ?? "" ?>
            </span>
        </header>
        <input id="surname" type="text" name="surname" value="<?= htmlspecialchars($_SESSION["surname"] ?? "") ?>" placeholder="Janssen" oninput="validateSurname()" onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>E-Mail</h3>
        </header>
        <input type="email" name="email" value="<?= htmlspecialchars($_SESSION["email"] ?? "") ?>" placeholder="jan.janssen@gmail.com" onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Telefoonnummer</h3>
            <span id="phonenumber-error" class="error">
                <?= $_SESSION["phonenumber-error"] ?? "" ?>
            </span>
        </header>
        <input id="phonenumber" type="text" name="phonenumber" value="<?= htmlspecialchars($_SESSION["phonenumber"] ?? "") ?>" placeholder="0612345678" oninput="validatePhonenumber()" onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Postcode</h3>
            <span id="postalcode-error" class="error">
                <?= $_SESSION["postalcode-error"] ?? "" ?>
            </span>
        </header>
        <input id="postalcode" type="text" name="postalcode" value="<?= htmlspecialchars($_SESSION["postalcode"] ?? "") ?>" placeholder="1234AB" oninput="validatePostalcode()" onfocus="this.select()" />
    </label>

    <input type="submit" name="create" value="Creëer" />
</form>
<script type="text/javascript">
    const salutationInput = document.getElementById("salutation");
    const salutationError = document.getElementById("salutation-error");

    const nameInput = document.getElementById("name");
    const nameError = document.getElementById("name-error");

    const surnameInput = document.getElementById("surname");
    const surnameError = document.getElementById("surname-error");

    const phonenumberInput = document.getElementById("phonenumber");
    const phonenumberError = document.getElementById("phonenumber-error");

    const postalcodeInput = document.getElementById("postalcode");
    const postalcodeError = document.getElementById("postalcode-error");

    function validateCreateForm() {
        validateSalutation();
        validateName();
        validateSurname();
        validatePhonenumber();
        validatePostalcode();

        return salutationInput.value !== "" && nameInput.value !== "" && surnameInput.value !== "" && phonenumberInput.value !== "" && postalcodeInput.value !== "";
    }

    function validateSalutation() {
        if (salutationInput.value === "") {
            salutationError.innerHTML = "Aanhef kan niet leeg zijn";
        } else {
            salutationError.innerHTML = "";
        }
    }

    function validateName() {
        if (nameInput.value === "") {
            nameError.innerHTML = "Naam kan niet leeg zijn";
        } else {
            nameError.innerHTML = "";
        }
    }

    function validateSurname() {
        if (surnameInput.value === "") {
            surnameError.innerHTML = "Achternaam kan niet leeg zijn";
        } else {
            surnameError.innerHTML = "";
        }
    }

    function validatePhonenumber() {
        if (phonenumberInput.value === "") {
            phonenumberError.innerHTML = "Telefoonnummer kan niet leeg zijn";
        } else {
            phonenumberError.innerHTML = "";
        }
    }

    function validatePostalcode() {
        if (postalcodeInput.value === "") {
            postalcodeError.innerHTML = "Postcode kan niet leeg zijn";
        } else {
            postalcodeError.innerHTML = "";
        }
    }
</script>
<?php

unset($_SESSION["salutation"]);
unset($_SESSION["name"]);
unset($_SESSION["surname"]);
unset($_SESSION["email"]);
unset($_SESSION["phonenumber"]);
unset($_SESSION["postalcode"]);

unset($_SESSION["salutation-error"]);
unset($_SESSION["name-error"]);
unset($_SESSION["surname-error"]);
unset($_SESSION["phonenumber-error"]);
unset($_SESSION["postalcode-error"]);

?>