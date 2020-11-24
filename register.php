<?php
//define variables and set to empty values
$fname = $email= $lname= $password= $cpassword= "";
//Error variables
$fnameErr = $emailErr= $usernameErr= $passwordErr= $cpasswordErr= $cpasswordMatch= $queryResult= $accSuccessful= "";
$counter = 1;
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

//Start the session
session_start();

//database creation
$createDB = "CREATE TABLE IF NOT EXISTS users(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL,
	fname VARCHAR(255) NOT NULL,
	lname VARCHAR(255) NOT NULL,
	password VARCHAR(50) NOT NULL,
	confirmPassword VARCHAR(50) NOT NULL,
  role VARCHAR(50) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP);";
mysqli_query($conn,$createDB);

//
if($_SERVER["REQUEST_METHOD"] == "POST")
{	
	//query
	$tempEmail = test_input($_POST["inputEmail"]);
	$tempPassword = test_input($_POST["inputPassword"]);
	$tempCPassword = test_input($_POST["confirmPassword"]);
	$sql = "SELECT email FROM users WHERE email = '$tempEmail'";
	$queryResult = mysqli_query($conn,$sql);
	
	//Check if the email exist 
  if(mysqli_num_rows($queryResult) > 0)
  {
    if(!empty($tempEmail)){
      $emailErr = "Email already exist in our dababase!";
    }
    
	}else if($tempPassword != $tempCPassword)
	{
     $cpasswordMatch = "Passwords do not match";
    
	}else{
		
		$accSuccessful = "**Successfully created new account** ";
		$email = test_input($_POST["inputEmail"]);
		$fname = test_input($_POST["firstName"]);
		$lname = test_input($_POST["lastName"]);
		$password = test_input($_POST["inputPassword"]);
		$cpassword = test_input($_POST["confirmPassword"]);
    	
   //Insert data
    $currentDate = date('Y-m-d H:m:s');
  	$sqlQuery="INSERT INTO users(id, email, fname, lname, password, confirmPassword, role, created_at)
	  VALUES('','$email','$fname','$lname','$password','$cpassword', 'user','$currentDate')";
  	//connect query to database
  	mysqli_query($conn, $sqlQuery); 
		
    
    //Check if the user account is create successful, if yes then redirect to login page
		if($accSuccessful == "**Successfully created new account**")
		{
			//header('Location: login.php');
		}
	}
  //echo Now();
}

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
} 


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Register</title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
		<button class="btn btn-success btn-block""><span align="left" style="color:white"><?php echo $accSuccessful?></span></button>
      <div class="card-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="text" name="firstName" id="firstName" class="form-control" placeholder="First name" required="required" autofocus="autofocus">
                  <label for="firstName">First name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last name" required="required">
                  <label for="lastName">Last name</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required="required"><span style="color:red"><?php echo $emailErr?></span>
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required="required">
                  <label for="inputPassword">Password</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm password" required="required">
                  <label for="confirmPassword">Confirm password</label>
				          <span align="left" style="color:red"><?php echo $cpasswordMatch?></span>
                </div>
              </div>
            </div>
          </div>
		  <button class="btn btn-primary btn-block" type="submit">Register</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
          <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
        </div>

      </div>
    </div>
  </div>

<!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
