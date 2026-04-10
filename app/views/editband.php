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
    <title>Edit Band</title>
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
        <h1>Edit Band</h1>

        <form method="post">
            <div>
                <label for="band_name">Band Name:</label>
                <input
                    type="text"
                    id="band_name"
                    name="band_name"
                    value="<?= htmlspecialchars($_POST['band_name'] ?? $band['name']) ?>">
                <?php if (!empty($errorList['band_name'])): ?>
                    <p><?= htmlspecialchars($errorList['band_name']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit">Save</button>
        </form>
    </main>
</body>

</html>