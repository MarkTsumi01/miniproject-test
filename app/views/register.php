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
        <h1>Register</h1>
        <form method="post">
            <label for="username">Username:</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            <br>
    
            <?php if (!empty($errorMessage['username'])): ?>
            <?= '<p>' . htmlspecialchars($errorMessage['username']) . '</p>' ?>
            <?php endif; ?>

            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                name="password">
            <br>

            <?php if (!empty($errorMessage['password'])): ?>
            <?= '<p>' . htmlspecialchars($errorMessage['password']) . '</p>' ?>
            <?php endif; ?>

            <button type="submit" name="register">Register</button>
        </form>
        <a href="index.php?page=login">Login</a>
    </body>
</html>
