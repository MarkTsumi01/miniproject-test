<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
    <title>Record List</title>
</head>
<body>
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
            <?php while ($record = $recordsResult->fetch_assoc()): ?>
            <tr>
                <td>
                    <a href="index.php?page=bandlist&record_id=<?php echo $record['id']; ?>">
                        <?php echo htmlspecialchars($record['name']); ?>
                    </a>
                </td>
                <td><?php echo $record['band_count']; ?></td>
                <td>
                    <a href="index.php?page=editrecord&record_id=<?php echo $record['id']; ?>">Edit</a>
                    
                    <form method="post" style="display:inline;">
                        <input 
                            type="hidden" 
                            name="delete_record_id" 
                            value="<?php echo $record['id']; ?>">
                        <input 
                            type="submit" 
                            value="Delete">
                    </form>
                    
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <form method="post">
        <input type="submit" value="Logout" name="logout">
    </form>
    
</body>
</html>