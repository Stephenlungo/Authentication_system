<?php
define('DB_SERVER','localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD','');
define('DB_DATABASE','loginsystem');

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);


if(!$connection)
{
    die("Error, could not connect. ". mysqli_connect_error());
}

?>