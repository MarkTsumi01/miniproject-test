<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album List</title>
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
            <li><a href="index.php?page=recordlist">Album List</a></li>
        </ul>
    </nav>

    <main>
        <h1>Album List</h1>

        <a href="index.php?page=addband&record_id=<?= (int) $recordId ?>">Add Album</a>

        <table border="1">
            <thead>
                <tr>
                    <th>Album Name</th>
                    <th>Songs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($albumResult as $album): ?>
                    <tr>
                        <td>
                            <a href="index.php?page=songlist&album_id=<?= (int) $album['id'] ?>">
                                <?= htmlspecialchars($album['name']) ?>
                            </a>
                        </td>
                        <td><?= (int) $album['song_count'] ?></td>
                        <td>
                            <a href="index.php?page=editalbum&album_id=<?= (int) $album['id'] ?>&band_id=<?= $bandId ?>">Edit</a>

                            <form method="post" style="display:inline;">
                                <input
                                    type="hidden"
                                    name="delete_album"
                                    value="<?= (int) $album['id'] ?>">
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