<!DOCTYPE html>
<html>
<head>
<title>Hall of Fame</title>
</head>
<body>
    <h3>Enter a record into the Hall of Fame</h3>
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
        if(isset($_POST['trainer_id']) || isset($_POST['pokemon_id'])) {

            $new_trainer = trim($_POST['trainer_id']);
            $new_pokemon = trim($_POST['pokemon_id']);

            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            $stmt = $conn->prepare("INSERT INTO hall_of_fame(trainer_id,pokemon_id)
                                VALUES (?,?);");
            $stmt->bind_param("ii", $new_trainer,$new_pokemon);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/hallOfFame.php");
            } else {
                echo "Unable to create new challenge";
                header("Location: http://final.cowman.xyz/addHOF.php");
            }
        }
    ?>
    
    <form action="/addHOF.php" method="POST">
        <label for="trainer_id">Trainer ID</label>
        <input type="text" name="trainer_id" value="">
        <br><br>
        <label for="pokemon_id">Pokemon ID</label>
        <input type="text" name="pokemon_id" value="">
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <br>

    <form action="/hallOfFame.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>