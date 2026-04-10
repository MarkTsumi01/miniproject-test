<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Record</title>
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
            <h1>Edit Record</h1>
            <form method="post">
                <div>
                    <label for="record_name">Record Name:</label>
                    <input
                        type="text"
                        id="record_name"
                        name="record_name"
                        value="<?= htmlspecialchars($_POST['record_name'] ?? $record['name']) ?>">

                    <?php if (!empty($errorList['record_name'])): ?>
                        <p><?= htmlspecialchars($errorList['record_name']) ?></p>
                    <?php endif; ?>

                </div>
                <button type="submit">Save</button>
            </form>
        </main>
    </body>
</html>
