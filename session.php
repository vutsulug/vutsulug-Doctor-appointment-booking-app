<?php
//define variables and set to empty values
$email= $password= "";
//Error variables
$inputErr= "";
//database connection
$servername="localhost";
$dbusername="root";
$dbpassword="";
$dbname="vutsulutech";

//create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
//Start the session
session_start();

//Storing session
$user_check =$_SESSION['login_user'];
//SQL to fetch complete information	
$sqlQuery = "SELECT email FROM user_details WHERE email = '$email' and password = '$password'";
$sqlQueryResult = mysqli_query($conn,$sqlQuery);
$rows = mysqli_num_rows($sqlQueryResult);
	
	if($rows == 1)
	{
		$_SESSION['login_user'] = $email;
		header('location: index.php');
	}else
	{
		$inputErr = "Your email or password is invalid.";
	}
	
//function that analyze user input
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
} 

mysqli_close($conn);
?>