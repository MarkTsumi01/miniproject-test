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
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                <br>
                <?php if (!empty($errorList['username'])) {
                    echo "<p>" . htmlspecialchars($errorList['username']) . "</p>";
                } ?>
            
                <label for="password">Password:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password">
                <br>
                <?php if (!empty($errorList["password"])) {
                    echo "<p>" . htmlspecialchars($errorList["password"]) . "</p>";
                } ?>
                <?php if (!empty($errorList["credentials"])) {
                    echo "<p>" . htmlspecialchars($errorList["credentials"]) . "</p>";
                } ?>
                
                <input type="submit" value="Login" name="submit">
            </form>
            
            <form method="post">
                <input type="submit" value="Register" name="register">
            </form>
            
    </body>
</html>