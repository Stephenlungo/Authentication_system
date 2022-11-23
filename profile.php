<!DOCTYPE html>
<html>
    <head>
        <title>My Account | Authentication System </title>
    </head>
<body>
    //PHP code follows here below


<?php

require_once "config.php";

session_start();

echo "<h1> WELCOME </h1>. " . $_SESSION['email'];

?>
<div>
<a href="logout.php">Logout</a>
</div>

<div>
<a href="reset.php">Reset Password</a> //this is a reset password reset link
</div>

</body>
</html>

