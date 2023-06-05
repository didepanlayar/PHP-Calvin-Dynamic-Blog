<?php

$base_url     = "https://calvin.maucode.tk";
$servername   = "localhost";
$username     = "username";
$password     = "password";
$databasename = "db_name";

$connect = mysqli_connect($servername, $username, $password, $databasename);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}