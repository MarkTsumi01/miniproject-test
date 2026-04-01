<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Login</title>
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</head>
<body>
    <h1>Login</h1>
    <div class='container'>
        <form method='post'>
            <label for='username'>Username:</label>
            <input type='text' id='username' name='username' 
                value='<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>'>
            <?php if (!empty($errorList['username'])): ?>
                <p><?php echo htmlspecialchars($errorList['username']); ?></p>
            <?php endif; ?>

            <label for='password'>Password:</label>
            <input type='password' id='password' name='password'>
            <?php if (!empty($errorList['password'])): ?>
                <p><?php echo htmlspecialchars($errorList['password']); ?></p>
            <?php endif; ?>

            <?php if (!empty($errorList['credentials'])): ?>
                <p><?php echo htmlspecialchars($errorList['credentials']); ?></p>
            <?php endif; ?>

            <input type='submit' value='Login' name='submit'>
        </form>
        <form method='post'>
            <input type='submit' value='Register' name='register'>
        </form>
    </div>
</body>
</html>
