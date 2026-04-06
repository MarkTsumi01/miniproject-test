<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Record</title>
    <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php?page=recordlist">Record List</a></li>
        </ul>
    </nav>

    <main>
        <h1>Add Record</h1>

        <form method="post">
            <div>
                <label for="record_name">Record Name:</label>
                <input
                    type="text"
                    id="record_name"
                    name="record_name"
                    value="<?= htmlspecialchars($_POST['record_name'] ?? '') ?>">
                <?php if (!empty($errorList['record_name'])): ?>
                    <p><?= htmlspecialchars($errorList['record_name']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit">Save</button>
        </form>
    </main>
</body>
</html>