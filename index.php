<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location: /A2/pages/login/login.html"); 
    exit;
}  else {
    header("location: /A2/welcome.php"); 
}
?>