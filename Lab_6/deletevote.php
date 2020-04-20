<?php 
session_start();
unset($_SESSION['yesCount']);
unset($_SESSION['noCount']);
header('Location: register.html');
?>