<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Add Record</title>
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</head>
<body>
    <h1>Add Record</h1>
    <form method='post'>
        <label for='record_name'>Record Name:</label>
        <input type='text' id='record_name' name='record_name' value='<?php echo isset($_POST['record_name']) ? htmlspecialchars($_POST['record_name']) : ''; ?>'>
        <?php if (!empty($errorList['record_name'])) {
                echo '<p>' . htmlspecialchars($errorList['record_name']) . '</p>';
        } ?>
        <input type='submit' value='Save'>
    </form>
</body>
</html>
