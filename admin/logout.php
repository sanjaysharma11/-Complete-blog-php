<?php 
include "../Config.php";
session_start();
session_unset();
session_destroy();
header("location:http://localhost/php-blog/login.php");
exit();
?>