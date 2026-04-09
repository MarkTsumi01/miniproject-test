<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <script>
            window.addEventListener("pageshow", function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        </script>
    </head>
    <body>
        <h1>Login</h1>
        <form method="post">
            <label for="username">Username:</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            <br>

            <?php if (!empty($errorData['username'])): ?>
            <?= '<p>' . htmlspecialchars($errorData['username']) . '</p>' ?>
            <?php endif; ?>

            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                name="password">
            <br>

            <?php if (!empty($errorData['password'])): ?>
            <?= '<p>' . htmlspecialchars($errorData['password']) . '</p>' ?>
            <?php endif; ?>

            <?php if (!empty($errorData['credentials'])): ?>
            <?= '<p>' . htmlspecialchars($errorData['credentials']) . '</p>' ?>
            <?php endif; ?>

            <button type="submit" name="login">Login</button>
        </form>
        <a href="index.php?page=register">Register</a>
    </body>
</html>
