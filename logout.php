<?php 
session_start();

require "koneksidb.php";

$_SESSION = [];
session_unset();

session_destroy();

setcookie('login', '', time() - 3600);

header("location: index.php");

exit;

 ?>