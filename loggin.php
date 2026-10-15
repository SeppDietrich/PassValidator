<?php
require_once("config.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Loggin page</title>
    <?php require_once("components/styleslink.php"); ?>

</head>
<body>
<style>
</style>
<!--Navbar-->
<?php require_once("components/navbar.php"); ?>
<!--LOGGIN CONTENT-->

<div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Log In</button>
    </form>
</div>




</div>
</body>
</html>
