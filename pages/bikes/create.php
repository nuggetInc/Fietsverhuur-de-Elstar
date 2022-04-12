<?php

declare(strict_types=1);

if (isset($_POST["create"]))
{
    if (!isset($_POST["framenumber"]) || $_POST["framenumber"] === "")
    {
        $_SESSION["framenumber-error"] = "Framenummer kan niet leeg zijn :(";

        header("Location: $uri");
        exit;
    }

    Bike::create($_POST["framenumber"], $_POST["comment"]);

    header("Location: $uri");
    exit;
}

?>
<form method="POST" onsubmit="return validateCreateForm()">
    <header>Registreren</header>

    <label class="field">
        <header>
            <h3>Framenummer</h3>
            <span id="framenumber-error" class="error">
                <?= $_SESSION["framenumber-error"] ?? "" ?>
            </span>
        </header>
        <input id="framenumber" oninput="validateFramenumber()" type="text" name="framenumber" value="<?= htmlspecialchars($_SESSION["framenumber"] ?? "") ?>" placeholder="Framenumber" autofocus onfocus="this.select()" />
    </label>

    <label class="field">
        <h3>Opmerking</h3>
        <textarea name="comment"></textarea>
    </label>

    <input type="submit" name="create" value="Creëer" />
</form>
<script type="text/javascript">
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
</script>
<?php

unset($_SESSION["framenumber"]);
unset($_SESSION["framenumber-error"]);

?>