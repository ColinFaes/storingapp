<?php
$action = $_POST['action'];
if($action == "registreren")
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];
    
    if(empty($username))
    {
        $errors[] = "Vul een gebruikersnaam in.";
    }

    if(empty($password))
    {
        $errors[] = "Vul een wachtwoord in.";
    }

    if($password != $password_check)
    {
        $errors[] = "De wachtwoorden komen niet overeen";
    }

    require_once 'conn.php';

	$query = "SELECT * FROM users WHERE username = :username";
	$statement = $conn->prepare($query);
	$statement->bindParam(":username", $username);
	$statement->execute();

    if($statement->rowCount() > 0)
    {
        $errors[] = "Een account met deze naam bestaat al, kies alstublieft een andere naam.";
    }

    if(isset($errors))
    {
        echo "Je hebt de volgende errors: \n";
        foreach ($errors as $error)
        {
            echo "<pre>";
            echo $error,"\r\n";
            echo "</pre>";
        }
        die();
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  
    
    require_once 'conn.php';

    $query="INSERT INTO users(username, password, naam) VALUES(:username, :password, :naam)";


    $statement=$conn->prepare($query);

    $statement->execute([
        ":username"=>$username,
        ":password"=>$hashed_password,
        ":naam"=>$username,
    ]);


    header("location: ../login.php?");
?>