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
    <main>
        <h1>Login</h1>

        <form method="post">
            <div>
                <label for="username">Username:</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                <?php if (!empty($errorList['username'])): ?>
                    <p><?= htmlspecialchars($errorList['username']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="password">Password:</label>
                <input
                    type="password"
                    id="password"
                    name="password">
                <?php if (!empty($errorList['password'])): ?>
                    <p><?= htmlspecialchars($errorList['password']) ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($errorList['credentials'])): ?>
                <p><?= htmlspecialchars($errorList['credentials']) ?></p>
            <?php endif; ?>

            <button type="submit" name="submit">Login</button>
        </form>

        <a href="index.php?page=register">Register</a>
    </main>
</body>
</html>