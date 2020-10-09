<!DOCTYPE html>
<html>
<head>
    <title>Create New Pokemon Type</title>
</head>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <h1>Create New Pokemon Type</h1>
    <?php
        // If there are any errors, we will inform the user here
        require_once('CustomError.php');
        $errors = CustomError::getErrors();
        foreach($errors as $err)
            echo "<p>$err</p>\n";
    ?>
    <hr>
    <?php
        // If post variables are set, let's get those and add them to the DB
        // If not, we'll produce a form to create new items
        if(isset($_POST['type_name']) || isset($_POST['description'])) {
            // Make sure we alert that there's an error if either name or
            // description does not exist
            $poke_name = trim($_POST['type_name']);
            $poke_desc = trim($_POST['description']);

            $redirect = false; // We'll set this as true when we're ready to redirect

            if($poke_name == "") {
                CustomError::setError('Pokemon type name is required!');
                $redirect = true;
            } elseif($poke_desc == "") {
                CustomError::setError('Pokemon type description is required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/createPokemonType.php");
                exit;
            }

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("INSERT INTO pokemon_type(type_name,
                                    description) VALUES (?, ?);");
            $stmt->bind_param("ss", $poke_name, $poke_desc);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/pokemonTypes.php");
            } else {
                CustomError::setError('Unable to create new pokemon type. ' . $conn->error);
                header("Location: http://final.cowman.xyz/createPokemonType.php");
            }
        }
    ?>
    
    <form action="/createPokemonType.php" method="POST">
        <label for="type_name">Pokemon TypeName</label>
        <input type="text" name="type_name" value="">
        <br><br>
        <label for="description">Pokemon Type Description</label>
        <input type="text" name="description" value="">
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <br>
    
    <form action="/pokemonTypes.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>