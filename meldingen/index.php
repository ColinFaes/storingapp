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
    <title>StoringApp / Meldingen</title>
    <?php require_once '../head.php'; ?>
</head>

<body>

    <?php require_once '../header.php'; ?>
    
    <div class="container">
        <h1>Meldingen</h1>
        <a href="create.php">Nieuwe melding &gt;</a>

        <?php if(isset($_GET['msg']))
        {
            echo "<div class='msg'>" . $_GET['msg'] . "</div>";
        } ?>

        <?php
            //Query uitvoeren:
            require_once '../backend/conn.php';
            if(empty($_GET['filter']))
            {
                $query = "SELECT * FROM meldingen";                    
                $statement = $conn->prepare($query);                      
                $statement->execute();                                     
            } 
            else
            {
                $query = "SELECT * FROM meldingen WHERE type = :filter";                    
                $statement = $conn->prepare($query);                      
                $statement->execute([
                    ":filter" => $_GET['filter']
                ]);
            }                                                         
            $meldingen = $statement->fetchAll(PDO::FETCH_ASSOC);      
        ?>

        <div class="info">
            <p>Aantal meldingen: <strong><?php echo count($meldingen);?></strong></p>
            <form action="" method="GET">
                <select name="filter" id="filter">
                    <option value=""> - kies een type - </option>
                    <option value="achtbaan">achtbaan</option>
                    <option value="draaiend">draaiend</option>
                    <option value="kinder">kinder</option>
                    <option value="horeca">horeca</option>
                    <option value="show">show</option>
                    <option value="water">water</option>
                    <option value="overig">overig</option>
                </select>
                <input type="submit" value="filter">
            </form>
        </div>

        <table>
            <tr>
                <th>Attractie</th>
                <th>Type</th>
                <th>Capaciteit</th>
                <th>Prioriteit</th>
                <th>Melder</th>
                <th>Gemeld op</th>
                <th>Overige info</th>
            </tr>
            <?php foreach($meldingen as $melding): ?>
                <tr>
                    <td><?php echo $melding['attractie']; ?></td>
                    <td><?php echo ucfirst($melding['type']); ?></td>
                    <td><?php echo $melding['capaciteit']; ?></td>
                    <td><?php if ($melding['prioriteit'] == 1)
                    {
                        echo "Ja";
                    }
                    else
                    {
                        echo "Nee";
                    }
                    ?></td>
                    <td><?php echo $melding['melder']; ?></td>
                    <td><?php echo $melding['gemeld_op']; ?></td>
                    <td><?php echo $melding['overige_info']; ?></td>
                    <td><?php echo "<a href='edit.php?id={$melding['id']}'>" ?>aanpassen</td>
                </tr>
            <?php endforeach; ?>
        </table>
    
    </div>  

</body>

</html>
