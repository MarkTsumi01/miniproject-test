<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Album</title>
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
        <h1>Add Album</h1>

        <form method="post">
            <div>
                <label for="album_name">Album Name:</label>
                <input
                    type="text"
                    id="album_name"
                    name="album_name"
                    value="<?= htmlspecialchars($_POST['album_name'] ?? '') ?>">
                <?php if (!empty($errorList['album_name'])): ?>
                    <p><?= htmlspecialchars($errorList['album_name']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit">Save</button>
        </form>
    </main>
</body>
</html>