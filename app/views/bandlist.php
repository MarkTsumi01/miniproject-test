<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Band List</title>
    <script>
        window.addEventListener('pageshow', function(event) {
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
        <h1>Band List</h1>

        <a href="index.php?page=addband&record_id=<?= (int) $recordId ?>">Add Band</a>

        <table border="1">
            <thead>
                <tr>
                    <th>Band Name</th>
                    <th>Albums</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bandResult as $band): ?>
                    <tr>
                        <td>
                            <a href="index.php?page=albumlist&band_id=<?= (int) $band['id'] ?>">
                                <?= htmlspecialchars($band['name']) ?>
                            </a>
                        </td>
                        <td><?= (int) $band['album_count'] ?></td>
                        <td>
                            <a href="index.php?page=editband&band_id=<?= (int) $band['id'] ?>&record_id=<?= $recordId ?>">Edit</a>

                            <form method="post" style="display:inline;">
                                <input
                                    type="hidden"
                                    name="delete_band"
                                    value="<?= (int) $band['id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>