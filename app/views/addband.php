<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Band</title>
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
        <h1>Add Band</h1>

        <form method="post">
            <div>
                <label for="band_name">Band Name:</label>
                <input
                    type="text"
                    id="band_name"
                    name="band_name"
                    value="<?= htmlspecialchars($_POST['band_name'] ?? '') ?>">
                <?php if (!empty($errorList['band_name'])): ?>
                    <p><?= htmlspecialchars($errorList['band_name']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="record_name">Choose Record:</label>
                <select name="record_name" id="record_name">
                    <?php while ($record = $recordResult->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($record['name']) ?>">
                            <?= htmlspecialchars($record['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit">Save</button>
        </form>
    </main>
</body>
</html>