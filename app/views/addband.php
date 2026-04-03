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
    <ul style="list-style-type:none; display:flex; gap:20px;">
        <li><a href="index.php?page=recordlist">Record List</a></li>
        <li><a href="index.php?page=bandlist">Band List</a></li>
    </ul>
    
    <h1>Add Band</h1>
    
    <form method="post">
        <label for="record_name">Band Name:</label>
        <input 
            type="text" 
            id="band_name" 
            name="band_name" 
            value="<?php echo isset($_POST["band_name"]) ? htmlspecialchars($_POST['band_name']) : ''; ?>">
        <?php if (!empty($errorList['band_name'])) {
            echo '<p>' . htmlspecialchars($errorList['band_name']) . '</p>';
        } ?>
        <br>
        
        <label for="record">Choose Record:</label>
        <select name="record_name" id="record">
          <?php while ($record = $recordResult->fetch_assoc()): ?>
              <option value="<?php echo $record['name']; ?>"><?php echo $record['name']; ?></option>
          <?php endwhile; ?>
        </select>
        <br>
        
        <input type="submit" value="Save">
    </form>
    
</body>
</html>