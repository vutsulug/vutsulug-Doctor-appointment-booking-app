<?php
//Initalize the session
session_start();

//Destroy session
session_destroy();
unset($_SESSION['login_user']);
//Redirect to login page
header('Location: login.php');
exit();

?>