<?php
session_start(); 


$_SESSION = array();


session_destroy();


header("location: /A2/pages/login/login.html"); 
exit();
?>