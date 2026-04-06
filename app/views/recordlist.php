<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record List</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php?page=recordlist">Record List</a></li>
        </ul>
    </nav>

    <main>
        <h1>Record List</h1>

        <a href="index.php?page=addrecord">Add Record</a>

        <table border="1">
            <thead>
                <tr>
                    <th>Record Name</th>
                    <th>Bands</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recordsResult as $record): ?>
                    <tr>
                        <td>
                            <a href="index.php?page=bandlist&record_id=<?= (int) $record['id'] ?>">
                                <?= htmlspecialchars($record['name']) ?>
                            </a>
                        </td>
                        <td><?= (int) $record['band_count'] ?></td>
                        <td>
                            <a href="index.php?page=editrecord&record_id=<?= (int) $record['id'] ?>">Edit</a>

                            <form method="post" style="display:inline;">
                                <input
                                    type="hidden"
                                    name="delete_record_id"
                                    value="<?= (int) $record['id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </main>
</body>
</html>