<?php

declare(strict_types=1);

// Only run logic if form was submitted
if (isset($_POST["login"]))
{
    if (!isset($_POST["name"]) || $_POST["name"] === "")
    {
        $_SESSION["login-name-error"] = "Username can't be empty :(";
    }

    if (!isset($_POST["password"]) || $_POST["password"] === "")
    {
        $_SESSION["login-password-error"] = "Password can't be empty :(";
    }

    if (isset($_SESSION["login-name-error"]) || isset($_SESSION["login-password-error"]))
    {
        // Reload page to clear POST and stop further execution
        header("Location: .");
        exit;
    }

    if ($database->hasEmployeeName($_POST["name"]))
    {
        $user = $database->getEmployee($_POST["name"]);
        $hash = $database->getEmployeeHash($user);

        if (password_verify($_POST["password"], $hash))
        {
            $_SESSION["user"] = $user;

            // Reload page with now logged in user
            header("Location: .");
            exit;
        }
    }

    // Empty strings means that there is an error, but no field specific message
    $_SESSION["login-error"] = "Username or password is incorrect :(";
    $_SESSION["login-name-error"] =  "";
    $_SESSION["login-password-error"] = "";

    // Save username value so we're able to restore it after a reload
    $_SESSION["login-name"] =  $_POST["name"];

    header("Location: .");
    exit;
}

?>
<div class="container">
    <form id="login" method="POST" onsubmit="return validateLoginForm()">
        <!-- Only create the element for storing the error if there is one -->
        <?php if (isset($_SESSION["login-error"])) : ?>
            <p id="login-error"><?= $_SESSION["login-error"] ?></p>
        <?php endif ?>

        <label><span class="label">Username<span id="login-name-error" class="error"><?= $_SESSION["login-name-error"] ?? "" ?></span></span>
            <input id="login-name" class="<?= isset($_SESSION["login-name-error"]) ? "error" : "" ?>" onkeyup="validateUsername()" type="text" name="name" value="<?= $_SESSION["login-name"] ?? "" ?>" placeholder="Username" autofocus />
        </label>

        <label><span class="label">Password<span id="login-password-error" class="error"><?= $_SESSION["login-password-error"] ?? "" ?></span></span>
            <input id="login-password" class="<?= isset($_SESSION["login-password-error"]) ? "error" : "" ?>" onkeyup="validatePassword()" type="text" name="name" placeholder="Password" />
        </label>

        <input class="submit" type="submit" name="login" value="Login" />
    </form>
</div>
<script type="text/javascript">
    /** @return {boolean} */
    function validateLoginForm() {
        const name = document.getElementById("login-name").value;
        const password = document.getElementById("login-password").value;

        if (name === "") {
            return false;
        }

        if (password === "") {
            return false;
        }

        return true;
    }

    function validateUsername() {
        const nameInput = document.getElementById("login-name");
        const nameError = document.getElementById("login-name-error");

        if (nameInput.value === "") {
            nameInput.classList.add("error");
            nameError.innerHTML = "Username can't be empty";
        } else {
            nameInput.classList.remove("error");
            nameError.innerHTML = "";
        }
    }

    function validatePassword() {
        const passwordInput = document.getElementById("login-password");
        const passwordError = document.getElementById("login-password-error");

        if (passwordInput.value === "") {
            passwordInput.classList.add("error");
            passwordError.innerHTML = "Password can't be empty";
        } else {
            passwordInput.classList.remove("error");
            passwordError.innerHTML = "";
        }
    }
</script>
<?php

// We don't want these session variables to bleed into other tabs.
unset($_SESSION["login-name"]);
unset($_SESSION["login-error"]);
unset($_SESSION["login-name-error"]);
unset($_SESSION["login-password-error"]);

?>