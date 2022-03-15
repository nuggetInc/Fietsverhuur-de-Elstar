<?php

declare(strict_types=1);

unset($_SESSION["user"]);

header("Location: .");
exit;
