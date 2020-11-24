<?php
//include "config.php";

//database connection
$servername="localhost";
$dbusername="root";
$dbpassword="";
$dbname="vutsulutech";

//create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
//Check connection
if(!$conn)
{
	die("Connection failed: ".mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS test_db(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL,
	fname VARCHAR(255) NOT NULL,
	lname VARCHAR(255) NOT NULL,
	password VARCHAR(25) NOT NULL,
	confirmPassword VARCHAR(25) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP);";
/*
	 	//Insert data
		 $sqlQuery="INSERT INTO users(id, email, fname, lname, password, confirmPassword, role, created_at)
		 VALUES('','$email','$fname','$lname','$password','$cpassword', 'user','sysdate()')";
		 //connect query to database
		 mysqli_query($conn, $sqlQuery);*/

		 $date = date('Y-m-d H:m:s');
		 echo $date;
  
if(mysqli_query($conn,$sql)){
echo "Database successfully created and ready for use.";
}else{
	echo "Not successful";
}

mysqli_close($conn);
?>

