<!doctype html>
<html lang="nl">

<head>
    <title>SecretAnimal</title>
    <?php require_once 'backend/config.php'; ?>

	<meta charset="utf-8">
	<meta name="description" content="StoringApp voor technische dienst van DeveloperLand">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo $base_url; ?>/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo $base_url; ?>/css/normalize.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>/css/main.css">
</head>

<header>
    <div class="container1">
        <a href="<?php echo $base_url; ?>/index.php"><i class="fa-solid fa-house"></i> Home pagina</a>
    </div>
</header>

<body>
    <div class="container home">
        <form action="backend/registerController.php" method="POST">
            <input type="hidden" name="action" value="registreren">
            <input type="text" id="username" name="username" placeholder="user">
            <input type="password" id="password" name="password" placeholder="pass">
            <input type="password" id="password_check" name="password_check" placeholder="pass_check">
            <!-- nog een submit-knop -->
            <input type="submit" value="registreren">
        </form>
    </div>  

</body>

</html>