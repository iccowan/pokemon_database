<!DOCTYPE html>
<html>
<head>
    <title>Create New Item</title>
</head>
<body>
    <h1>Create New Item</h1>
    <hr>
    <?php
        // Enable error reporting
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // If post variables are set, let's get those and add them to the DB
        // If not, we'll produce a form to create new items
        
    ?>
    
    <form action="deleteFromTable.php" method=POST>\n
        <label for="item_name">Item Name</label>
        <input type="text" name="item_name">
        <br>
        <label for="item_description">Item Description</label>
        <input type="textarea" name="item_description">
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>