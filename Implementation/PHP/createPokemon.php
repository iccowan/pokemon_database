<!DOCTYPE html>
<html>
<head>
    <title>Create New Pokemon</title>
</head>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <h1>Create New Pokemon</h1>
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
        if(isset($_POST['pokemon_name']) || isset($_POST['pokemon_type_id']) || isset($_POST['pokemon_level']) || isset($_POST['trainer_id'])) {
            // Make sure we alert that there's an error if either name or
            // description does not exist
            $poke_name = trim($_POST['pokemon_name']);
            $poke_type_id = trim($_POST['pokemon_type_id']);
            $poke_level = trim($_POST['pokemon_level']);
            $trainer_id = trim($_POST['trainer_id']);

            $redirect = false; // We'll set this as true when we're ready to redirect

            if($poke_name == "") {
                CustomError::setError('Pokemon name is required!');
                $redirect = true;
            } elseif($poke_type_id == "") {
                CustomError::setError('Pokemon type is required!');
                $redirect = true;
            } elseif($poke_level == "") {
                CustomError::setError('Pokemon level is required!');
                $redirect = true;
            } elseif($trainer_id =="") {
                CustomError::setError('A trainer is required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/createPokemon.php");
                exit;
            }

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("INSERT INTO pokemon(pokemon_name,
                                    pokemon_type_id, pokemon_level, trainer_id) VALUES (?, ?, ?, ?);");
            $stmt->bind_param("siii", $poke_name, $poke_type_id, $poke_level, $trainer_id);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/pokemon.php");
            } else {
                CustomError::setError('Unable to create new pokemon. ' . $conn->error);
                header("Location: http://final.cowman.xyz/createPokemon.php");
            }
        }
    ?>
    
    <form action="/createPokemon.php" method="POST">
        <label for="item_name">Pokemon Name</label>
        <input type="text" name="pokemon_name" value="">
        <br><br>
        <label for="pokemon_type_id">Pokemon Type ID</label>
        <input type="text" name="pokemon_type_id" value="">
        <br><br>
        <label for="pokemon_level">Pokemon Level</label>
        <input type="text" name="pokemon_level" value="">
        <br><br>
        <label for="trainer_id">Trainer ID</label>
        <input type="text" name="trainer_id" value="">
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <br>
    
    <form action="/pokemon.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>