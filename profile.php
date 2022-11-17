<!DOCTYPE html>
<html>
    <head>
        <title>Profile | Authentication System </title>
    </head>
<body>


<?php

require_once "config.php";

session_start();

echo "<h1> WELCOME </h1>. " . $_SESSION['email'];

?>
<div>
<a href="logout.php">Logout</a>
</div>

<div>
<a href="reset.php">Reset Password</a>
</div>

</body>
</html>

