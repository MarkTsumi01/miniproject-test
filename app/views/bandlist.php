<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Band List</title>
    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</head>
<body>
    <ul style="list-style-type:none; display:flex; gap:20px;">
        <li><a href="index.php?page=recordlist">Record List</a></li>
        <li><a href="index.php?page=bandlist">Band List</a></li>
    </ul>

    <h1>Band List</h1>
    
    <a href="index.php?page=addband">Add Band</a>
    
    <table border="1">
        <thead>
            <tr>
                <th>Band Name</th>
                <th>Albums</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($band = $bandResult->fetch_assoc()): ?>
            <tr>
                <td>
                    <a href="index.php?page=bandlist&record_id=<?php echo $band['id']; ?>">
                        <?php echo htmlspecialchars($band['name']); ?>
                    </a>
                </td>
                <td><?php echo $band['album_count']; ?></td>
                <td>
                    <a href="index.php?page=editrecord&record_id=<?php echo $band['id']; ?>">Edit</a>
                    
                    <form method="post" style="display:inline;">
                        <input 
                            type="hidden" 
                            name="delete_record_id" 
                            value="<?php echo $band['id']; ?>">
                        <input 
                            type="submit" 
                            value="Delete">
                    </form>
                    
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>