<?php 

function showError(array $errorData, string $field): void
{
    if (!empty($errorData[$field])) {
        echo '<p>' . htmlspecialchars($errorData[$field]) . '</p>';
    }
} 

?>

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
                <?php showError($errorData, 'username') ?>
            </div>
            <div>
                <label for="password">Password:</label>
                <input
                    type="password"
                    id="password"
                    name="password">
                <?php showError($errorData, 'password') ?>
            </div>
            <?php showError($errorData, 'credentials') ?>
            <button type="submit" name="login">Login</button>
        </form>

        <a href="/register">Register</a>
    </main>
</body>
</html>