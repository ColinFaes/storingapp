<?php
session_start();
if(!isset($_SESSION['user_id']))
{
    $msg = "Je moet eerst inloggen!";
    header("Location: ../login.php?msg=$msg");
    exit;
}
?>
<!doctype html>
<html lang="nl">

<head>
    <title>StoringApp / Meldingen / Aanpassen</title>
    <?php require_once '../head.php'; ?>
</head>

<body>
    <?php 

    if(!isset($_GET['id'])){
        echo "Geef in je aanpaslink op de index.php het id van betreffende item mee achter de URL in je a-element om deze pagina werkend te krijgen na invoer van je vijfstappenplan";
        exit;

    }
    ?>
    <?php
        require_once '../header.php'; ?>

    <div class="container">
        <h1>Melding aanpassen</h1>

        <?php
        //Haal het id uit de URL:
        $id = $_GET['id'];

        //1. Haal de verbinding erbij
        require_once '../backend/conn.php';

        //2. Query, vul deze aan met een WHERE zodat je alleen de melding met dit id ophaalt
        $query = "SELECT * FROM meldingen WHERE id = :id";

        //3. Van query naar statement
        $statement = $conn->prepare($query);

        //4. Voer de query uit, voeg hier nog de placeholder toe
        $statement->execute([":id" => $id]);

        //5. Ophalen gegevens, tip: gebruik hier fetch().
        $melding = $statement->fetch(PDO::FETCH_ASSOC)
        ?>

        <form action="../backend/meldingenController.php" method="POST">
            <!-- (voeg hier opdracht 7 toe) -->
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?php echo $id?>">
            <div class="form-group">
                <label for="attractie">Naam attractie:</label>
                <?php echo $melding['attractie']; ?>
            </div>
            <div class="form-group">
                <label for="type">Attractie type:</label>
                <?php echo $melding['type']; ?>
            </div>
            <!-- Zorg dat het type wordt getoond, net als de naam hierboven -->
            <div class="form-group">
                <label for="capaciteit">Capaciteit p/uur:</label>
                <input type="number" min="0" name="capaciteit" id="capaciteit" class="form-input"
                    value="<?php echo $melding['capaciteit']; ?>">
            </div>
            <div class="form-group">
                <label for="prioriteit">Prio:</label>
                <!-- Let op: de checkbox blijft nu altijd uit, pas dit nog aan -->
                <input type="checkbox" name="prioriteit" id="prioriteit" 
                <?php if ($melding['prioriteit'])
                {
                    echo 'checked';
                }
                ?>>
                <label for="prioriteit">Melding met prioriteit</label>
            </div>
            <div class="form-group"> 
                <label for="melder">Naam melder:</label>
                <!-- Voeg hieronder nog een value-attribuut toe, zoals bij capaciteit -->
                <input type="text" name="melder" id="melder" class="form-input" value="<?php echo $melding['melder']; ?>">
            </div>
            <div class="form-group">
                <label for="overig">Overige info:</label>
                <textarea name="overig" id="overig" class="form-input" rows="4"><?php echo $melding['overige_info'] ?></textarea>
            </div>
            
            <input type="submit" value="Melding opslaan">

        </form>
    </div>  

</body>

</html>
