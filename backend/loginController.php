<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

require_once 'conn.php';
$query = "SELECT * FROM users WHERE username = :username";
$statement = $conn ->prepare($query);
$statement -> execute([":username" => $username]);
$user = $statement -> fetch(PDO::FETCH_ASSOC);

if ($statement -> rowCount() < 1)
{
    die("error: account bestaat niet");
}

if (!password_Verify($password, $user['password']))
{
    die("error: wachtwoord niet juist");
}

$_SESSION['user_id'] = $user['id'];

header("location: ../index.php?");
