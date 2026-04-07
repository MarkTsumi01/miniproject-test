<?php

if (!defined('APP_RUNNING')) {
    http_response_code(403);
    die('Direct access is not allowed');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</head>
<body>
    <main>
        <h1>Register</h1>

        <form method="post">
            <div>
                <label for="username">Username:</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                <?php if (!empty($errorData['username'])): ?>
                    <p><?= htmlspecialchars($errorData['username']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="password">Password:</label>
                <input
                    type="password"
                    id="password"
                    name="password">
                <?php if (!empty($errorData['password'])): ?>
                    <p><?= htmlspecialchars($errorData['password']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" name="register">Register</button>
        </form>

        <a href="index.php?page=login">Login</a>
    </main>
</body>
</html>