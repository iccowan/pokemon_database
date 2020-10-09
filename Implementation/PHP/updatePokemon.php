<!DOCTYPE html>
<html>
<head>
    <title>Update Pokemon</title>
</head>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <h1>Update Pokemon</h1>
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
            $poke_id = trim($_POST['pokemon_id']);
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
                header("Location: http://final.cowman.xyz/updatePokemon.php");
                exit;
            }

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("UPDATE pokemon
                                    SET pokemon_name = ?, pokemon_type_id = ?, pokemon_level = ?, trainer_id = ?
                                    WHERE pokemon_id = ?;");
            $stmt->bind_param("siii", $poke_name, $poke_type_id, $poke_level, $trainer_id, $poke_id);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/pokemon.php");
            } else {
                CustomError::setError('Unable to update pokemon. ' . $conn->error);
                header("Location: http://final.cowman.xyz/updatePokemon.php");
            }
        }
    ?>

    <?php
        // Get the item that is referenced
        require_once('DBConnect.php');

        if(! isset($_GET['pokemon_id'])) {
            CustomError::setError('Must select the pokemon to update.');
            header('Location: http://final.cowman.xyz/pokemon.php');
            exit;
        }

        $connection = new DBConnect();
        $conn = $connection->getConnection();
        $stmt = $conn->prepare('SELECT * FROM pokemon WHERE pokemon_id = ?');

        $pokemon_id = $_GET['pokemon_id'];
        $stmt->bind_param('i', $pokemon_id);
        
        if(! $stmt->execute()) {
            CustomError::setError('Error getting pokemon: ' . $conn->error);
            header('Location: http://final.cowman.xyz/pokemon.php');
            exit;
        }

        // Now, we know the item result exists
        $poke_res = $stmt->get_result()->fetch_all();
        $poke_id = $poke_res[0][0];
        $poke_name = $poke_res[0][1];
        $poke_type_id = $poke_res[0][2];
        $poke_level = $poke_res[0][3];
        $poke_trainer_id = $poke_res[0][4];
    ?>
    
    <form action="/updatePokemon.php" method="POST">
    <label for="pokemon_name">Pokemon Name</label>
        <input type="hidden" name="pokemon_id" value="<?php echo $poke_id ?>">
        <input type="text" name="pokemon_name" value="<?php echo $poke_name ?>">
        <br><br>
        <label for="pokemon_type_id">Pokemon Type ID</label>
        <input type="text" name="pokemon_type_id" value="<?php echo $poke_type_id ?>">
        <br><br>
        <label for="pokemon_level">Pokemon Level</label>
        <input type="text" name="pokemon_level" value="<?php echo $poke_level ?>">
        <br><br>
        <label for="trainer_id">Trainer ID</label>
        <input type="text" name="trainer_id" value="<?php echo $poke_trainer_id ?>">
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <br>
    
    <form action="/pokemon.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>