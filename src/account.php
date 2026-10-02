<?php

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/require_login.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account | Food Festive</title>
</head>
<body>
    <h1>
        Welcome,
        <?= htmlspecialchars($_SESSION["name"], ENT_QUOTES, "UTF-8") ?>
    </h1>

    <p>You are logged in.</p>
    <a href="/logout">Logout</a>
</body>
</html>
