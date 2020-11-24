<?php
//database connection
$servername="localhost";
$dbusername="root";
$dbpassword="";
$dbname="vutsulutech";
//create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
// Initialize the session
session_start();
 
// Define variables and initialize with empty values
$tempEmail = "";
$email_err = $email_success = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{        
   
   //Validate user input email address
   $tempEmail = test_input($_POST["inputEmail"]);
   $sqlQuery = "SELECT id FROM users WHERE email = '$tempEmail'";
   $queryResults = mysqli_query($conn, $sqlQuery);
   
   if(mysqli_num_rows($queryResults) > 0)
   {
	   //Generate a token 
	   $userToken = "token_generator(10)";
	   //$message = $userToken;
	   
	   //send email
	   $to_email = 'nyikovu@gmail.com';
	   $subject = 'Testing PHP Mail';
	   $message = 'This mail is sent using the PHP mail function';
	   $headers = 'From: noreply@company.com';
	   mail($to_email,$subject,$message,$headers);
	   $email_success = "Succesfully sent, check your emails to reset password";
   }else{
	   $email_err = "Email address does not exist in our records";
   }
    
}

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
} 

    // Close connection
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

  <title>Forgot Password</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
	  <span align="" style= "color:green"><h5><?php echo $email_success?></h5></span>
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>Forgot your password?</h4>
          <p>Enter your email address and we will send you instructions on how to reset your password.</p>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Enter email address" required="required" autofocus="autofocus">
              <label for="inputEmail">Enter email address</label>
			  <span align="left" style= "color:red"><?php echo $email_err?></span>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit">Confirm</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Register an Account</a>
          <a class="d-block small" href="login.php">Login Page</a>
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
