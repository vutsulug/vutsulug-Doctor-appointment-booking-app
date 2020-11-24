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
else{
 //doctor's database creation
 $createDB = "CREATE TABLE IF NOT EXISTS doctor(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	staffNo VARCHAR(255) NOT NULL,
	title VARCHAR(3) NOT NULL,
  	fname VARCHAR(255) NOT NULL,
	lname VARCHAR(255) NOT NULL,
	email VARCHAR(50) NOT NULL,
	speciality VARCHAR(50) NOT NULL,
  	status VARCHAR(50) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	role VARCHAR(50) NOT NULL);";
mysqli_query($conn,$createDB);

 //appointment database creation
 $queryCreateDB = "CREATE TABLE IF NOT EXISTS appointment(
	appointment_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	staffNo VARCHAR(255) NOT NULL,
	doctor_fname VARCHAR(255) NOT NULL,
	doctor_lname VARCHAR(255) NOT NULL,
  	patient_fname VARCHAR(255) NOT NULL,
	patient_lname VARCHAR(255) NOT NULL,
	appointment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  	status VARCHAR(50) NOT NULL);";
mysqli_query($conn,$queryCreateDB);
}

?>

