<?php
$host = "localhost";
//$user = "root";
//$pass = "";
//$db = "helal";
$user = "hellal";
$pass = "MOda0124359417";
$db = "hellal";
$connect = mysqli_connect($host, $user, $pass, $db) or die('Cant connect with database');
mysqli_set_charset($connect, "utf8");

ob_start();
session_start();
?>