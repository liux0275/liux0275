<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>CP476 Convenience Store</title>
    <?php
        include ("database.php");
        include ("auth.php");
        if (isset($_POST["submit"])) {
            auth();
        }
    ?>
</head>
<body>
    <h1>Convenience Store</h1>
    <div class="container">
        <form method="post">
            <label for="uid"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uid" required>

            <label for="pw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pw" required>

            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>
</html>
