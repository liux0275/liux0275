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
    <script>
        function openPwForm() {
            document.getElementById("pw-form").style.display = "block";
        }
        function closePwForm() {
            document.getElementById("pw-form").style.display = "none";
        }
        function openShop() {
            document.getElementById("overlay").style.display = "block";
        }
        function closeShop() {
            document.getElementById("overlay").style.display = "none";
        }
    </script>
    <?php
        include ("data.php");
        include ("database.php");
        include ("auth.php");
        if (isset($_POST["btn-pw"])) {
            changePw($_POST["pw"]);
            unset($_POST);
        }
        if (isset($_POST["logout"])) {
            session_unset();
            session_destroy();
            unset($_POST);
            echo '<script> document.location.href = "index.php"</script>';
        }
        if (isset($_POST["update"])) {
            updateCart($_POST["update"],$_POST[$_POST["update"]]);
            #echo '<script>alert("' . $_POST[$_POST["update"]] . '");</script>';
            unset($_POST["update"]);
        }
        if (isset($_POST["addToCart"])) {
            addCart($_POST["addToCart"],$_POST[$_POST["addToCart"]]);
            unset($_POST["addToCart"]);
        }
        if (isset($_POST["removeCart"])) {
            delCart($_POST["removeCart"]);
            unset($_POST["removeCart"]);
        }
    ?>
    <title>Cart</title>
</head>
<body>
    <h1>Shopping Cart</h1>
    <div class="user">
        <form method="post">
            Username: <?php echo $_SESSION["uid"];?><br>
            <button type="button" onclick="openPwForm()">Change Password</button><br>
            <button type="submit" name="logout">Logout</button>
        </form>
        
    </div>
    <div class="pw-form" id="pw-form">
        <form method="post">
            <h1>Change Password</h1>
            <input type="text" placeholder="Enter New Password" name="pw" required>
            <button type="submit" name="btn-pw">Change Password</button>
            <button type="button" onclick="closePwForm()">Cancel</button>
        </form>
    </div>
    <?php
        readCart();
        shopList();
    ?>
    <div class="btn-shop">
        <button onclick="openShop()">Open Shop</button>
    </div>
</body>
</html>
